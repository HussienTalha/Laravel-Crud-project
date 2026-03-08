<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     /**
         * @return Collection<int,Category> 
         */
    public function index(): Collection
    {
        /**
         * @return Collection<Category> 
         */
        $categories = Category::all();

        return $categories;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse 

    {
        $this->authorize('create', Category::class);
        $validated = $request->validate(
            [
                'category_name' => 'required|string|unique:categories',
            ]
        );
        $validated['category_name'] = ucwords($validated['category_name']);
        Category::create($validated);

        return redirect('admin/dashboard')->with('success', 'Category Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): View
    {

        /**
         * @var LengthAwarePaginator<int,Post> $posts
         */
         $posts = $category->posts()->with(['user:id,name'])->latest()->paginate(9);
            /**
             * @var Collection<int,Category> $categories
             */
        
        $categories = Category::all();

        return view('category', compact('category', 'categories', 'posts'));
    }

    public function update(Request $request, Category $category):RedirectResponse
    {
        $this->authorize('update', Category::class);
        $validated = $request->validate(
            [
                'category_name' => 'required|string|unique:categories',
            ]
        );
        $validated['category_name'] = ucwords($validated['category_name']);
        $category->update($validated);

        return redirect('/admin/dashboard')->with('success', 'category updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category):RedirectResponse
    {
        /**
         * @var Category $uncategorized
         */
        $uncategorized = Category::where('Category_name', '=', 'Uncategorized')->first();
        /**
         * @var Post $affected_posts 
         */
        $affected_posts = Post::where('category_id', '=', $category->id)->update(['category_id' => $uncategorized->id]);
        $this->authorize('delete', Category::class);
        $category->delete();

        return redirect('/admin/dashboard')->with('success', 'category delete!');
    }
}
