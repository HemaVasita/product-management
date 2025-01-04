<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

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
                    return '<img src="'.asset('storage/'.$row->image).'" width="50">';
                })
                ->editColumn('category', function ($row) {
                    return $row->category->name;
                })
                ->addColumn('action', function ($row) {
                    return '
                        <a href="'.route('products.edit', $row->id).'" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="'.$row->id.'">Delete</button>
                    ';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
    
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['success' => 'Product deleted successfully.']);
    }
}
