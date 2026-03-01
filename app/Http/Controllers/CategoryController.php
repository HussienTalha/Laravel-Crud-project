<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return $categories;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Category::class);
        $validated = $request->validate(
            [
                'category_name' => 'required|string|unique:categories'
            ]
        );
        $validated['category_name'] = ucwords($validated['category_name']);
        Category::create($validated);
        return redirect('admin/dashboard')->with('success', 'Category Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        
        $posts = $category->posts()->with(['user:id,name'])->paginate(9);
        $categories = Category::all();
        return view('category', compact('category','categories','posts'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorize('update' , Category::class);
        $validated = $request->validate(
            [
                'category_name' =>'required|string|unique:categories'
            ]
        );
        $validated['category_name'] = ucwords($validated['category_name']);
        $category->update($validated);
        return redirect('/admin/dashboard')->with('success','category updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', Category::class);
        $category->delete();
        return redirect('/admin/dashboard')->with('success','category delete!');
    }
}
