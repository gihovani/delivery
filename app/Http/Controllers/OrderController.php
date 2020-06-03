<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;

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
        return view('orders.create');
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
