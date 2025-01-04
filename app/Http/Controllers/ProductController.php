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
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::with('category')->select(['id', 'title', 'category_id', 'type', 'image', 'created_at']);
            return DataTables::of($products)
                ->editColumn('image', function ($row) {
                    return '
                        <a href="' . Storage::url($row->image) . '" target="_blank">
                            <img src="' . Storage::url($row->image) . '" width="50" class="img-fluid custom-img">
                        </a>';
                })
                ->editColumn('category', function ($row) {
                    return '<a href="/categories/' . $row->category_id . '/edit">' . $row->category->name . '</a>';
                })
                ->editColumn('created_at', function ($row) {
                    // Format the created_at date to 'YYYY-MM-DD'
                    return Carbon::parse($row->created_at)->format('Y-m-d');
                })
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
                ->rawColumns(['image', 'category', 'action'])
                ->make(true);
        }

        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        $tags = Tag::select('id', 'name')->get();
        return view('products.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // Handle image upload
        $imagePath = Storage::putFile('products', $request->file('image'));

        // Handle product creation
        $product = Product::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'price' => $request->price,
            'type' => $request->type,
        ]);

        // Attach tags
        $product->tags()->sync($request->tags);

        return redirect()->route('products.index')->with('success', __('Product created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::select('id', 'name')->get();
        $tags = Tag::select('id', 'name')->get();
        return view('products.edit', compact('categories', 'tags', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // Check if a new image was uploaded and handle it
        if ($request->hasFile('image')) {
            // Delete the old image
            Storage::delete($product->image);

            // Upload the new image
            $imagePath = Storage::putFile('products', $request->file('image'));
            $product->image = $imagePath;
        }

        // Update product details
        $product->category_id = $request->category_id;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->type = $request->type;
        $product->save();

        // Sync the tags
        $product->tags()->sync($request->tags);

        return redirect()->route('products.index')->with('success', __('Product updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete the image associated with the product
        Storage::delete($product->image);

        // Delete the product
        $product->delete();

        return response()->json(['success' => __('Product deleted successfully.')]);
    }
}
