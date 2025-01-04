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
     * Display a listing of the categories.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Check if the request is an AJAX request
        if ($request->ajax()) {
            // Fetch categories data
            $categories = Category::select(['id', 'name', 'description', 'created_at']);
            
            // Return data in DataTables format with custom columns
            return DataTables::of($categories)
                // Format the created_at column to 'YYYY-MM-DD'
                ->editColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('Y-m-d');
                })
                // Add an action column with Edit and Delete buttons
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
                // Specify that the action column contains raw HTML
                ->rawColumns(['action'])
                ->make(true);
        }

        // Return the categories index view
        return view('categories.index');
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the view to create a new category
        return view('categories.create');
    }

    /**
     * Store a newly created category in the database.
     *
     * @param StoreCategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        // Create a new category using the validated data from the request
        Category::create($request->validated());

        // Redirect back to the categories index page with a success message
        return redirect()->route('categories.index')->with('success', __('Category created successfully!'));
    }

    /**
     * Display the specified category.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        // This function is currently empty but could be used to show detailed info of a category
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        // Return the edit view with the category data
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category in the database.
     *
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        // Update the category with the validated data from the request
        $category->update($request->validated());

        // Redirect back to the categories index page with a success message
        return redirect()->route('categories.index')->with('success', __('Category updated successfully!'));
    }

    /**
     * Remove the specified category from the database.
     *
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        // Delete the category from the database
        $category->delete();

        // Return a JSON response with a success message
        return response()->json(['success' => __('Category deleted successfully.')]);
    }
}
