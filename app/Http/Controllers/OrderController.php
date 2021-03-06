<?php

namespace App\Http\Controllers;

use App\Category;
use App\Config;
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
        $model = Product::orderBy('category_id')->orderBy('name', 'desc')->get();
        return ProductResource::collection($model);
    }

    private function getAllVariations()
    {
        return VariationResource::collection(Variation::orderBy('name')->get());
    }

    public function store(OrderRequest $request)
    {
        /** @var Order $order */
        $order = Order::create($this->getData($request));
        foreach ($this->items as $item) {
            $order->items()->create($item);
        }

        $message = __('Entity saved successfully.');
        return request()->ajax() ?
            response()
                ->json(['data' => $order, 'message' => $message]) :
            redirect()
                ->route('orders.index')
                ->with('status', $message);
    }

    private function getData(Request $request)
    {
        $data = $request->all();
        $formatMoney = [
            'discount', 'shipping_amount', 'additional_amount',
            'subtotal', 'amount', 'cash_amount', 'back_change'
        ];
        $subtotal = $this->getTotalItems($request);
        foreach ($formatMoney as $inputKey) {
            $data[$inputKey] = Order::removeMaskMoney($data[$inputKey]);
        }
        $data['subtotal'] = $subtotal;
        $data['amount'] = ($subtotal + $data['additional_amount'] + $data['shipping_amount']) - $data['discount'];
        $data['back_change'] = ($data['cash_amount'] && $data['cash_amount'] > $data['amount']) ? ($data['cash_amount'] - $data['amount']) : 0;
//        if ($subtotal > $data['subtotal']) {
//            abort(409);
//        }
        return $data;
    }

    private function getTotalItems(Request $request)
    {
        $this->items = [];
        $amount = 0;
        if ($request->has('items')) {
            $items = $request->post('items');
            $productPrices = $this->getProductPrices($items);
            foreach ($items as $item) {
                if (!isset($productPrices[$item['product_id']])) {
                    continue;
                }
                $price = $productPrices[$item['product_id']];
                $quantity = intval($item['quantity']);
                $item['quantity'] = $quantity;
                $item['price'] = $price;
                $this->items[] = $item;
                $amount += ($price * $quantity);
            }
        }
        return $amount;
    }

    private function getProductPrices($items)
    {
        $ids = [];
        foreach ($items as $item) {
            $ids[] = $item['product_id'];
        }
        $ret = [];
        $products = Product::whereIn('id', $ids)->get(['id', 'price']);
        foreach ($products as $product) {
            $ret[$product->id] = $product->price;
        }
        return $ret;
    }

    public function processing(Request $request, Order $order)
    {
        return $this->updateStatus($request, $order, Order::STATUS_PROCESSING, 'The order being produced.');
    }

    private function updateStatus(Request $request, Order $order, $status, $message)
    {
        if (in_array($order->status, [Order::STATUS_CANCELED, Order::STATUS_COMPLETE])) {
            abort(404, __('Not permited'));
        }
        if ($request->has('deliveryman_id')) {
            $order->deliveryman_id = $request->post('deliveryman_id');
        }
        $order->status = $status;
        $order->save();
        $message = __($message);
        $telephone = Order::onlyNumbers($order->customer_telephone);

        if (strlen($telephone) === 11) {
            $whatsappUrl = Config::getWhatsappApi() . $telephone . '&text=' . urlencode($message);
            $message = '<a href="' . $whatsappUrl . '" target="_blank"><i class="fab fa-whatsapp"></i> ' . $message . '</a>';
        }
        return request()->ajax() ?
            response()
                ->json(['data' => $order, 'message' => $message]) :
            redirect()
                ->route('orders.index')
                ->with('status', $message);
    }

    public function delivery(Request $request, Order $order)
    {
        return $this->updateStatus($request, $order, Order::STATUS_DELIVERY, 'The order is pending delivery.');
    }

    public function complete(Request $request, Order $order)
    {
        return $this->updateStatus($request, $order, Order::STATUS_COMPLETE, 'The order has been completed.');
    }

    public function canceled(Request $request, Order $order)
    {
        return $this->updateStatus($request, $order, Order::STATUS_CANCELED, 'The order has been canceled.');
    }

    public function print(Order $order)
    {
        if ($order->status === Order::STATUS_PENDING) {
            $order->status = Order::STATUS_PROCESSING;
            $order->save();
        }

        $view = view('orders.print', compact('order'));
        return response($view)
            ->header('Content-Type', 'text/plain');
    }
}
