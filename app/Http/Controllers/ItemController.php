<?php

namespace App\Http\Controllers;

use App\Item;
use App\Http\Requests\ItemRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::eloquent(Item::latest())
                ->make(true);
        }

        return view('items.index');
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(ItemRequest $request)
    {
        $item = Item::create($this->getData($request));
        return request()->ajax() ?
            response()
                ->json(['data' => $item, 'message' => __('Entity saved successfully.')]) :
            redirect()->route('items.index');
    }

    public function show(Item $item)
    {
        return request()->ajax() ?
            response()
                ->json(['data' => $item, 'message' => __('Show Data')]) :
            view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        return request()->ajax() ?
            response()
                ->json(['data' => $item, 'message' => __('Edit Data')]) :
            view('items.edit', compact('item'));
    }

    public function update(ItemRequest $request, Item $item)
    {
        $item->update($this->getData($request));
        return request()->ajax() ?
            response()
                ->json(['data' => $item, 'message' => __('Entity updated successfully.')]) :
            redirect()->route('items.index');;
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return request()->ajax() ?
            response()
                ->json(['data' => $item, 'message' => __('Entity successfully deleted.')]) :
            redirect()->route('items.index');
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
