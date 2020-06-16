<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use DataTables;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::eloquent(Category::latest())
                ->make(true);
        }

        return view('categories.index');
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->all());
        $message = __('Entity saved successfully.');
        return request()->ajax() ?
            response()
                ->json(['data' => $category, 'message' => $message]) :
            redirect()
                ->route('categories.index')
                ->with('status', $message);
    }

    public function show(Category $category)
    {
        return request()->ajax() ?
            response()
                ->json(['data' => $category, 'message' => __('Show Data')]) :
            view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return request()->ajax() ?
            response()
                ->json(['data' => $category, 'message' => __('Edit Data')]) :
            view('categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->all());
        $message = __('Entity updated successfully.');
        return request()->ajax() ?
            response()
                ->json(['data' => $category, 'message' => $message]) :
            redirect()
                ->route('categories.index')
                ->with('status', $message);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        $message = __('Entity successfully deleted.');
        return request()->ajax() ?
            response()
                ->json(['data' => $category, 'message' => $message]) :
            redirect()
                ->route('categories.index')
                ->with('status', $message);
    }
}
