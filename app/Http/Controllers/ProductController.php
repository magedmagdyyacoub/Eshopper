<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::latest()->paginate(5);

        return view('admin.products.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all(); // Get all categories for dropdown
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }

        Product::create($input);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $categories = Category::all(); // Get all categories for dropdown
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        } else {
            unset($input['image']);
        }

        $product->update($input);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }
     /**
     * Display the specified product details.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function showw(int $id)
    {
        $product = Product::findOrFail($id);
        return view('product.detail', compact('product'));
    }
    
    public function search(Request $request)
{
    $query = $request->input('query');

    // Search products and categories by name
    $products = Product::where('name', 'LIKE', "%{$query}%")->get();
    $categories = Category::where('name', 'LIKE', "%{$query}%")->get();

    // Create a combined result array
    $results = [];

    // Format products for the response
    foreach ($products as $product) {
        $results[] = [
            'name' => $product->name,
            'url' => route('product.detail', $product->id), // Assuming you have a route for product detail
            'type' => 'product'
        ];
    }

    // Format categories for the response
    foreach ($categories as $category) {
        $results[] = [
            'name' => $category->name,
            'url' => route('category-products', $category->id), // Assuming you have a route for category detail
            'type' => 'category'
        ];
    }

    // Return JSON response for AJAX requests
    return response()->json($results);
}
  /**
     * Search products by name and return JSON for autocomplete.
     */
    public function autocomplete(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'LIKE', "%{$query}%")->take(5)->get();

        $results = [];

        foreach ($products as $product) {
            $results[] = [
                'type' => 'product',
                'name' => $product->name,
                'id' => $product->id,
            ];
        }

        return response()->json($results);
    }
}
