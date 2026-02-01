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
        Category::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

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
        auth()->user()->create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category = $category->load(['posts:title','user:name,email']);
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {   
    }

    /**
     * Update the specified resource in storage.
     */
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
        return redirect('/')->with('success','category updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', Category::class);
        $category->delete();
        return redirect('/')->with('success','category delete!');
    }
}
