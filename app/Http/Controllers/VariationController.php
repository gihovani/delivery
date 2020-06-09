<?php

namespace App\Http\Controllers;

use App\Http\Resources\VariationResource;
use App\Variation;
use App\Http\Requests\VariationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;

class VariationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = Variation::all();
            return Datatables::of(VariationResource::collection($model))
                ->make(true);
        }

        return view('variations.index');
    }

    public function create()
    {
        return view('variations.create');
    }

    public function store(VariationRequest $request)
    {
        $variation = Variation::create($request->all());
        $this->saveImageAndItems($request, $variation);
        return request()->ajax() ?
            response()
                ->json(['data' => $variation, 'message' => __('Entity saved successfully.')]) :
            redirect()->route('variations.index');
    }

    public function show(Variation $variation)
    {
        return request()->ajax() ?
            response()
                ->json(['data' => $variation, 'message' => __('Show Data')]) :
            view('variations.show', compact('variation'));
    }

    public function edit(Variation $variation)
    {
        return request()->ajax() ?
            response()
                ->json(['data' => $variation, 'message' => __('Edit Data')]) :
            view('variations.edit', compact('variation'));
    }

    public function update(VariationRequest $request, Variation $variation)
    {
        $variation->update($request->all());
        $this->saveImageAndItems($request, $variation);
        return request()->ajax() ?
            response()
                ->json(['data' => $variation, 'message' => __('Entity updated successfully.')]) :
            redirect()->route('variations.index');
    }

    public function destroy(Variation $variation)
    {
        $variation->delete();
        return request()->ajax() ?
            response()
                ->json(['data' => $variation, 'message' => __('Entity successfully deleted.')]) :
            redirect()->route('variations.index');
    }

    private function saveImageAndItems(Request $request, Variation $variation)
    {
        if ($request->has('items')) {
            $variation->items()->sync($request->post('items'));
        }
        if ($request->hasFile('image')) {
            $request->file('image')
                ->storeAs(Variation::getFilePath(), $variation->image);
        }
    }
}
