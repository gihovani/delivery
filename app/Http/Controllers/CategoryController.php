<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DataTables;

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
        Category::create($request->all());
        return request()->ajax() ?
            new Response(__('Entity saved successfully.'), 201) :
            redirect()->route('categories.index');
    }

    public function show(Category $category)
    {
        return request()->ajax() ?
            $category :
            view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return request()->ajax() ?
            $category :
            view('categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->all());
        return request()->ajax() ?
            new Response(__('Entity updated successfully.')) :
            redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return request()->ajax() ?
            new Response(__('Entity successfully deleted.'), 209) :
            redirect()->route('categories.index');
    }
}
