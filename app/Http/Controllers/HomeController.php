<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }
  
    /**
     * Show the application home page.
     *
     * @return View
     */
    public function index(): View
    {
        // Get 6 random categories along with the number of products in each category
        $categories = Category::withCount('products')->inRandomOrder()->limit(6)->get();
        // Fetch 8 random products
        $randomProducts = Product::inRandomOrder()->limit(8)->get(); 
          // Retrieve the latest 8 products
          $latestProducts = Product::orderBy('created_at', 'desc')->take(8)->get();
        return view('home.home', compact('categories', 'randomProducts','latestProducts'));
    }
  
    /**
     * Show the admin home page.
     *
     * @return View
     */
    public function adminHome(): View
    {
        return view('admin.home');
    }
  
    /**
     * Show the manager home page.
     *
     * @return View
     */
    public function managerHome(): View
    {
        return view('managerHome');
    }
    public function search(Request $request)
{
    $query = $request->input('query');

    // Fetch categories for the view
    $categories = Category::all();

    if (!$query) {
        return view('home.home', ['products' => [], 'categories' => $categories]);
    }

    // Search in products and categories
    $products = Product::where('name', 'LIKE', "%{$query}%")
                ->orWhereHas('category', function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%");
                })
                ->get();

    return view('home', [
        'products' => $products,
        'categories' => $categories
    ]);
}
}
