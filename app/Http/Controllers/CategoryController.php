<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Category::class, "category");
    }

    public function index()
    {
        $categories = Category::all();
        return view("categories.index", compact("categories"));
    }

    public function create()
    {
        return view("categories.create");
    }

    public function store(StoreCategoryRequest $request)
    {
        Category::create([
            "name" => $request->name,
        ]);

        return redirect()->route("categories.index")->with("success", "Category created successfully.");
    }

    public function show(Category $category)
    {
        return view("categories.show", compact("category"));
    }

    public function edit(Category $category)
    {
        return view("categories.edit", compact("category"));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update([
            "name" => $request->name,
        ]);

        return redirect()->route("categories.index")->with("success", "Category updated successfully.");
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route("categories.index")->with("success", "Category deleted successfully.");
    }
}
