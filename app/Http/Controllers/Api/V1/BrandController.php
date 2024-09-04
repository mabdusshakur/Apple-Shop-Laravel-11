<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ResponseHelper;
use App\Helpers\TokenAuth;
use App\Models\Brand;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $brands = Brand::all();
            return ResponseHelper::sendSuccess('Brands retrieved successfully', $brands, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Failed to retrieve brands', $th->getMessage(), 500);
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
    public function store(StoreBrandRequest $request)
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

            $brand = Brand::create($data);

            if (!$brand) {
                return ResponseHelper::sendError('Failed to create brand', null, 500);
            }

            return ResponseHelper::sendSuccess('Brand created successfully', $brand, 201);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Failed to create brand', $th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        try {
            return ResponseHelper::sendSuccess('Brand retrieved successfully', $brand, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Failed to retrieve brand', $th->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
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
                if ($brand->image && file_exists(public_path($brand->image))) {
                    unlink(public_path($brand->image));
                }
            } else {
                $data['image'] = $brand->image;
            }

            $brand->update($data);

            return ResponseHelper::sendSuccess('Brand updated successfully', $brand, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Failed to update brand', $th->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        try {
            $is_admin = TokenAuth::isAdmin(request());

            if (!$is_admin) {
                return ResponseHelper::sendError('You are not authorized to perform this action', null, 403);
            }

            if ($brand->image && file_exists(public_path($brand->image))) {
                unlink(public_path($brand->image));
            }
            $brand->delete();

            return ResponseHelper::sendSuccess('Brand deleted successfully', null, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Failed to delete brand', $th->getMessage(), 500);
        }
    }
}