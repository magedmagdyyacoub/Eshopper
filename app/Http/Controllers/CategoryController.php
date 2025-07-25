<?php
  
namespace App\Http\Controllers;
  
use App\Models\category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
  
class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return response()
     */
    public function index(): View
    {
        $categories = category::latest()->paginate(5);
        
        return view('admin.categories.index',compact('categories'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }
  
    /**
     * Store a newly created resource in storage.
     */
      public function store(Request $request): RedirectResponse
{
    // Validate the input, making the image field nullable
    $request->validate([
        'name' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Retrieve all input data
    $input = $request->all();

    // Check if an image is uploaded
    if ($image = $request->file('image')) {
        // Define the destination path
        $destinationPath = 'images/';
        // Create a unique filename for the image
        $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
        // Move the image to the destination folder
        $image->move($destinationPath, $profileImage);
        // Add the image path to the input data
        $input['image'] = "$profileImage";
    } else {
        // Set image to null if no file is uploaded
        $input['image'] = null;
    }

    // Store the category (or whatever the logic is for saving the input)
    Category::create($input);

    // Redirect to the desired route with success message
    return redirect()->route('admin.categories.index')
                     ->with('success', 'Category created successfully.');
}
    
  
    /**
     * Display the specified resource.
     */
    public function show(category $category): View
    {
        return view('admin.categories.show', compact('category'));
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, category $category): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable'
        ]);
    
        $input = $request->all();
    
        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }else{
            unset($input['image']);
        }
            
        $category->update($input);
      
        return redirect()->route('admin.categories.index')
                         ->with('success', 'category updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(category $category): RedirectResponse
    {
        $category->delete();
         
        return redirect()->route('admin.categories.index')
                         ->with('success', 'category deleted successfully');
    }
    public function usershow($id)
{
    $category = Category::with('products')->findOrFail($id);
    return view('category-products', compact('category'));
}

}
