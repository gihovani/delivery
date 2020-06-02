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
        Item::create($this->getData($request));
        return request()->ajax() ?
            new Response(__('Entity saved successfully.'), 201) :
            redirect()->route('items.index');
    }

    public function show(Item $item)
    {
        return request()->ajax() ?
            $item :
            view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        return request()->ajax() ?
            $item :
            view('items.edit', compact('item'));
    }

    public function update(ItemRequest $request, Item $item)
    {
        $item->update($this->getData($request));
        return request()->ajax() ?
            new Response(__('Entity updated successfully.')) :
            redirect()->route('items.index');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return request()->ajax() ?
            new Response(__('Entity successfully deleted.'), 209) :
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
