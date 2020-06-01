<?php

namespace App\Http\Controllers;

use App\ProductItem;
use App\Http\Requests\ProductItemRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;

class ProductItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductItem::latest()->get();
            return Datatables::of($data)->make(true);
        }

        return view('product_items.index');
    }

    public function create()
    {
        return view('product_items.create');
    }

    public function store(ProductItemRequest $request)
    {
        ProductItem::create($this->getData($request));
        return request()->ajax() ?
            new Response(__('Entity saved successfully.'), 201) :
            redirect()->route('product_items.index');
    }

    public function show(ProductItem $productItem)
    {
        return request()->ajax() ?
            $productItem :
            view('product_items.show', compact('productItem'));
    }

    public function edit(ProductItem $productItem)
    {
        return request()->ajax() ?
            $productItem :
            view('product_items.edit', compact('productItem'));
    }

    public function update(ProductItemRequest $request, ProductItem $productItem)
    {
        $productItem->update($this->getData($request));
        return request()->ajax() ?
            new Response(__('Entity updated successfully.')) :
            redirect()->route('product_items.index');
    }

    public function destroy(ProductItem $productItem)
    {
        $productItem->delete();
        return request()->ajax() ?
            new Response(__('Entity successfully deleted.'), 209) :
            redirect()->route('product_items.index');
    }

    private function getData(Request $request)
    {
        $data = $request->all();
        if (strpos($data['price'], ',')) {
            $data['price'] = floatval(str_replace(['.',','], ['', '.'], $data['price']));
        }
        return $data;
    }
}
