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
        $message = __('Entity saved successfully.');
        return request()->ajax() ?
            response()
                ->json(['data' => $item, 'message' => $message]) :
            redirect()
                ->route('items.index')
                ->with('status', $message);
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
        $message = __('Entity updated successfully.');
        return request()->ajax() ?
            response()
                ->json(['data' => $item, 'message' => $message]) :
            redirect()
                ->route('items.index')
                ->with('status', $message);
    }

    public function destroy(Item $item)
    {
        $item->delete();
        $message = __('Entity successfully deleted.');
        return request()->ajax() ?
            response()
                ->json(['data' => $item, 'message' => $message]) :
            redirect()
                ->route('items.index')
                ->with('status', $message);
    }

    private function getData(Request $request)
    {
        $data = $request->all();
        $data['price'] = Item::removeMaskMoney($data['price']);
        return $data;
    }
}
