<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\VariationResource;
use App\Order;
use App\Product;
use App\Variation;
use DataTables;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $items = [];

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = Order::all();
            return Datatables::of(OrderResource::collection($model))
                ->make(true);
        }
        return view('orders.index');
    }

    public function create()
    {
        $data = [
            'categories' => $this->getAllCategories(),
            'products' => $this->getAllProducts(),
            'variations' => $this->getAllVariations()
        ];
        return view('orders.create', $data);
    }

    private function getAllCategories()
    {
        return CategoryResource::collection(Category::all());
    }

    private function getAllProducts()
    {
        $model = Product::orderBy('category_id')->orderBy('name')->get();
        return ProductResource::collection($model);
    }

    private function getAllVariations()
    {
        return VariationResource::collection(Variation::all());
    }

    public function store(OrderRequest $request)
    {
        /** @var Order $order */
        $order = Order::create($this->getData($request));
        foreach ($this->items as $item) {
            $order->items()->create($item);
        }

        return request()->ajax() ?
            response()
                ->json(['data' => $order, 'message' => __('Entity saved successfully.')]) :
            redirect()->route('orders.index');
    }

    private function getData(Request $request)
    {
        $data = $request->all();
        $formatMoney = [
            'discount', 'shipping_amount', 'subtotal',
            'total', 'cash_amount', 'back_change'
        ];
        $subtotal = $this->getTotalItems($request);
        foreach ($formatMoney as $inputKey) {
            $data[$inputKey] = $this->removeMaskMoney($data[$inputKey]);
        }
        if ($subtotal > $data['subtotal']) {
            abort(409);
        }
        return $data;
    }

    private function getTotalItems(Request $request)
    {
        $this->items = [];
        $total = 0;
        if ($request->has('items')) {
            $items = $request->post('items');
            foreach ($items as $item) {
                $product = Product::where('id', $item['product_id'])->first();
                if (!$product) {
                    continue;
                }

                $quantity = intval($item['quantity']);
                $item['quantity'] = $quantity;
                $item['price'] = $product->price;
                $this->items[] = $item;
                $total += ($product->price * $quantity);
            }
        }
        return $total;
    }

    private function removeMaskMoney($value = '0,0')
    {
        return floatval(str_replace(['.', ','], ['', '.'], $value));
    }
}
