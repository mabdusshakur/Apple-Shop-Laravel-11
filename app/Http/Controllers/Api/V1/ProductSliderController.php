<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ResponseHelper;
use App\Helpers\TokenAuth;
use App\Models\ProductSlider;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductSliderRequest;
use App\Http\Requests\UpdateProductSliderRequest;

class ProductSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ProductSlider::all();
        return ResponseHelper::sendSuccess('Product sliders retrieved successfully', $data, 200);
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
    public function store(StoreProductSliderRequest $request)
    {
        try {
            $is_admin = TokenAuth::isAdmin($request);

            if (!$is_admin) {
                return ResponseHelper::sendError('You are not authorized to perform this action', null, 403);
            }

            $data = $request->all();
            if ($request->hasFile('image')) {
                $img = $request->file('image');
                $img_name = time() . '.' . $img->getClientOriginalExtension();
                $img->move(public_path('uploads/images'), $img_name);
                $data['image'] = 'uploads/images/' . $img_name;
            }

            $productSlider = ProductSlider::create($data);
            return ResponseHelper::sendSuccess('Product slider created successfully', $productSlider, 201);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Internal server error', null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductSlider $productSlider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductSlider $productSlider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductSliderRequest $request, ProductSlider $productSlider)
    {
        try {
            $is_admin = TokenAuth::isAdmin($request);

            if (!$is_admin) {
                return ResponseHelper::sendError('You are not authorized to perform this action', null, 403);
            }

            $data = $request->all();
            if ($request->hasFile('image')) {
                $img = $request->file('image');
                $img_name = time() . '.' . $img->getClientOriginalExtension();
                $img->move(public_path('uploads/images'), $img_name);
                $data['image'] = 'uploads/images/' . $img_name;

                if ($productSlider->image && file_exists(public_path($productSlider->image))) {
                    unlink(public_path($productSlider->image));
                }
            } else {
                $data['image'] = $productSlider->image;
            }

            $productSlider->update($data);
            return ResponseHelper::sendSuccess('Product slider updated successfully', $productSlider, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Internal server error', null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSlider $productSlider)
    {
        try {
            $is_admin = TokenAuth::isAdmin(request());

            if (!$is_admin) {
                return ResponseHelper::sendError('You are not authorized to perform this action', null, 403);
            }

            if ($productSlider->image && file_exists(public_path($productSlider->image))) {
                unlink(public_path($productSlider->image));
            }
            $productSlider->delete();
            return ResponseHelper::sendSuccess('Product slider deleted successfully', null, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Internal server error', null, 500);
        }
    }
}