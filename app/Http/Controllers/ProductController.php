<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = Product::all();
            return Datatables::of(ProductResource::collection($model))
                ->make(true);
        }

        return view('products.index');
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->all());
        $this->saveItemsAndVariations($request, $product);
        return request()->ajax() ?
            new Response(__('Entity saved successfully.'), 201) :
            redirect()->route('products.edit', $product);
    }

    public function show(Product $product)
    {
        return request()->ajax() ?
            $product :
            view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return request()->ajax() ?
            $product :
            view('products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->all());
        $this->saveItemsAndVariations($request, $product);
        return request()->ajax() ?
            new Response(__('Entity updated successfully.')) :
            redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return request()->ajax() ?
            new Response(__('Entity successfully deleted.'), 209) :
            redirect()->route('products.index');
    }

    private function saveItemsAndVariations(Request $request, Product $product)
    {
        $product->items()->sync($request->post('items'));
        $request->file('image')
            ->storeAs('images/products/' . $product->category_id, $product->image, ['disk' => 'public']);
        $variations = $request->post('variation');
        if (empty($variations)) {
            return;
        }

        foreach ($variations as $variationId => $variation) {
            $price = floatval(str_replace(['.',','], ['', '.'], $variation['price']));
            $product->variations()
                ->attach([
                    'variation_id' => $variationId
                ], ['price' => $price]);
        }
    }
}
