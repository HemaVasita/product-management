<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Check if the request is an AJAX request
        if ($request->ajax()) {
            // Fetch products along with their category data
            $products = Product::with('category')->select(['id', 'title', 'category_id', 'type', 'image', 'created_at']);

            // Return data in DataTables format with custom columns
            return DataTables::of($products)
                // Format the image column as a clickable image link
                ->editColumn('image', function ($row) {
                    return '
                        <a href="' . Storage::url($row->image) . '" target="_blank">
                            <img src="' . Storage::url($row->image) . '" width="50" class="img-fluid custom-img" alt="product">
                        </a>';
                })
                // Format the category column as a clickable link to the category edit page
                ->editColumn('category', function ($row) {
                    return '<a href="/categories/' . $row->category_id . '/edit">' . $row->category->name . '</a>';
                })
                // Format the created_at column to display date in 'YYYY-MM-DD' format
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('Y-m-d');
                })
                // Add an action column with Edit and Delete buttons
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route('products.edit', $row->id) . '" class="btn btn-info btn-sm">
                            <i class="bi bi-pencil me-2"></i>Edit
                        </a>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">
                            <i class="bi bi-trash me-2"></i>Delete
                        </button>
                    ';
                })
                // Specify which columns should be raw HTML
                ->rawColumns(['image', 'category', 'action'])
                ->make(true);
        }

        // Return the view for the index page
        return view('products.index');
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Fetch categories and tags to show in the form
        $categories = Category::select('id', 'name')->get();
        $tags = Tag::select('id', 'name')->get();

        // Return the view for creating a product
        return view('products.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param StoreProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        // Handle image upload and store the image in the 'products' folder
        $imagePath = Storage::putFile('products', $request->file('image'));

        // Create a new product with the form data
        $product = Product::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'price' => $request->price,
            'type' => $request->type,
        ]);

        // Attach the selected tags to the product
        $product->tags()->sync($request->tags);

        // Redirect back to the products index with a success message
        return redirect()->route('products.index')->with('success', __('Product created successfully.'));
    }

    /**
     * Display the specified product.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // Show product details (currently empty)
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        // Fetch categories and tags to show in the form for editing
        $categories = Category::select('id', 'name')->get();
        $tags = Tag::select('id', 'name')->get();

        // Return the view for editing the product
        return view('products.edit', compact('categories', 'tags', 'product'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // Check if a new image was uploaded and handle it
        if ($request->hasFile('image')) {
            // Delete the old image from storage
            Storage::delete($product->image);

            // Upload the new image and update the product's image path
            $imagePath = Storage::putFile('products', $request->file('image'));
        }

        // Update the product's details with the new data
        $product->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath ?? $product->image,
            'price' => $request->price,
            'type' => $request->type,
        ]);

        // Sync the selected tags with the product
        $product->tags()->sync($request->tags);

        // Redirect back to the products index with a success message
        return redirect()->route('products.index')->with('success', __('Product updated successfully.'));
    }

    /**
     * Remove the specified product from storage.
     *
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        // Delete the image associated with the product from storage
        Storage::delete($product->image);

        // Delete the product record from the database
        $product->delete();

        // Return a JSON response with a success message
        return response()->json(['success' => __('Product deleted successfully.')]);
    }
}
