<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Order;
use App\Product;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::eloquent(Order::latest())
                ->make(true);
        }
        return view('orders.index');
    }

    public function create()
    {
        $categories = $this->getAllCategories();
        $products = $this->getAllProducts();
        return view('orders.create', compact('categories'), compact('products'));
    }

    private function getAllCategories()
    {
        return CategoryResource::collection(Category::all());
    }

    private function getAllProducts()
    {
        return ProductResource::collection(Product::orderBy('category_id')->orderBy('name')->get());
    }

    public function store(OrderRequest $request)
    {
        Order::create($request->all());
        return request()->ajax() ?
            new Response(__('Entity saved successfully.'), 201) :
            redirect()->route('orders.index');
    }

    public function show(Order $order)
    {
        return request()->ajax() ?
            $order :
            view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return request()->ajax() ?
            $order :
            view('orders.edit', compact('order'));
    }

    public function update(OrderRequest $request, Order $order)
    {
        $order->update($request->all());
        return request()->ajax() ?
            new Response(__('Entity updated successfully.')) :
            redirect()->route('orders.index');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return request()->ajax() ?
            new Response(__('Entity successfully deleted.'), 209) :
            redirect()->route('orders.index');
    }
}
