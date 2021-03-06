<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Product;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    private function getData(Request $request)
    {
        $data = $request->all();
        $data['price'] = Product::removeMaskMoney($data['price']);
        return $data;
    }
    public function store(ProductRequest $request)
    {
        $product = Product::create($this->getData($request));
        $this->saveImageAndVariations($request, $product);
        $message = __('Entity saved successfully.');
        return request()->ajax() ?
            response()
                ->json(['data' => $product, 'message' => $message]) :
            redirect()
                ->route('products.index')
                ->with('status', $message);
    }

    private function saveImageAndVariations(Request $request, Product $product)
    {
        if ($request->has('variations')) {
            $product->variations()->sync($request->post('variations'));
        }
        if ($request->hasFile('image')) {
            $request->file('image')
                ->storeAs(Product::getFilePath(), $product->image);
        }
    }

    public function show(Product $product)
    {
        return request()->ajax() ?
            response()
                ->json(['data' => $product, 'message' => __('Show Data')]) :
            view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return request()->ajax() ?
            response()
                ->json(['data' => $product, 'message' => __('Edit Data')]) :
            view('products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($this->getData($request));
        $this->saveImageAndVariations($request, $product);
        $message = __('Entity updated successfully.');
        return request()->ajax() ?
            response()
                ->json(['data' => $product, 'message' => $message]) :
            redirect()
                ->route('products.index')
                ->with('status', $message);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        $message = __('Entity successfully deleted.');
        return request()->ajax() ?
            response()
                ->json(['data' => $product, 'message' => $message]) :
            redirect()
                ->route('products.index')
                ->with('status', $message);
    }

    public function details(Product $product)
    {
        return view('products.details', compact('product'));
    }
}
