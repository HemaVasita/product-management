<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::select(['id', 'name', 'description', 'created_at']);
            return DataTables::of($categories)
                ->addColumn('created_at', function ($row) {
                    // Format the created_at date to 'YYYY-MM-DD'
                    return Carbon::parse($row->created_at)->format('Y-m-d');
                })
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route('categories.edit', $row->id) . '" class="btn btn-info btn-sm">
                            <i class="bi bi-pencil me-2"></i>Edit
                        </a>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="' . $row->id . '">
                            <i class="bi bi-trash me-2"></i>Delete
                        </button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());
        return redirect()->route('categories.index')->with('success', __('Category created successfully!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return redirect()->route('categories.index')->with('success', __('Category updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['success' => 'Category deleted successfully.']);
    }
}
