<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ResponseHelper;
use App\Helpers\TokenAuth;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories = Category::all();
            return ResponseHelper::sendSuccess('Categories retrieved successfully', $categories, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Failed to retrieve categories', $th->getMessage(), 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $is_admin = TokenAuth::isAdmin(request());

            if (!$is_admin) {
                return ResponseHelper::sendError('You are not authorized to perform this action', null, 403);
            }

            $data = $request->all();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/images'), $image_name);
                $data['image'] = 'uploads/images/' . $image_name;
            }

            $category = Category::create($data);

            if (!$category) {
                return ResponseHelper::sendError('Failed to create category', null, 500);
            }

            return ResponseHelper::sendSuccess('Category created successfully', $category, 201);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Failed to create category', $th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        try {
            return ResponseHelper::sendSuccess('Category retrieved successfully', $category, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Failed to retrieve category', $th->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $is_admin = TokenAuth::isAdmin(request());

            if (!$is_admin) {
                return ResponseHelper::sendError('You are not authorized to perform this action', null, 403);
            }

            $data = $request->all();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/images'), $image_name);
                $data['image'] = 'uploads/images/' . $image_name;
                if ($category->image && file_exists(public_path($category->image))) {
                    unlink(public_path($category->image));
                }
            } else {
                $data['image'] = $category->image;
            }

            $category->update($data);

            return ResponseHelper::sendSuccess('Category updated successfully', $category, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Failed to update category', $th->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $is_admin = TokenAuth::isAdmin(request());

            if (!$is_admin) {
                return ResponseHelper::sendError('You are not authorized to perform this action', null, 403);
            }

            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }
            $category->delete();
            return ResponseHelper::sendSuccess('Category deleted successfully', null, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Failed to delete category', $th->getMessage(), 500);
        }
    }
}