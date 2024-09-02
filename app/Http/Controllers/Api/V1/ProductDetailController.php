<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\ResponseHelper;
use App\Helpers\TokenAuth;
use App\Models\ProductDetail;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductDetailRequest;
use App\Http\Requests\UpdateProductDetailRequest;

class ProductDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    private function uploadImage($request, $image)
    {
        if ($request->hasFile($image)) {
            $img = $request->file($image);
            $img_name = time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('uploads/images'), $img_name);
            return 'uploads/images/' . $img_name;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductDetailRequest $request)
    {
        try {
            $is_admin = TokenAuth::isAdmin(request());

            if (!$is_admin) {
                return ResponseHelper::sendError('You are not authorized to perform this action', null, 403);
            }

            $data = $request->all();

            $data['img1'] = $this->uploadImage($request, 'img1');
            $data['img2'] = $this->uploadImage($request, 'img2');
            $data['img3'] = $this->uploadImage($request, 'img3');
            $data['img4'] = $this->uploadImage($request, 'img4');

            $productDetail = ProductDetail::create($data);

            if (!$productDetail) {
                ResponseHelper::sendError('Failed to create product detail', null, 500);
            }

            ResponseHelper::sendSuccess('Product detail created successfully', $productDetail, 201);
        } catch (\Throwable $th) {
            ResponseHelper::sendError('Failed to create product detail', $th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductDetail $productDetail)
    {
        try {
            return ResponseHelper::sendSuccess('Product detail retrieved successfully', $productDetail->with('product', 'product.brand', 'product.category'), 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Failed to get product detail', $th->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductDetail $productDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductDetailRequest $request, ProductDetail $productDetail)
    {
        try {
            $is_admin = TokenAuth::isAdmin(request());

            if (!$is_admin) {
                return ResponseHelper::sendError('You are not authorized to perform this action', null, 403);
            }

            $data = $request->all();

            if ($request->hasFile('img1')) {
                $data['img1'] = $this->uploadImage($request, 'img1');
            } else {
                $data['img1'] = $productDetail->img1;
            }

            if ($request->hasFile('img2')) {
                $data['img2'] = $this->uploadImage($request, 'img2');
            } else {
                $data['img2'] = $productDetail->img2;
            }

            if ($request->hasFile('img3')) {
                $data['img3'] = $this->uploadImage($request, 'img3');
            } else {
                $data['img3'] = $productDetail->img3;
            }

            if ($request->hasFile('img4')) {
                $data['img4'] = $this->uploadImage($request, 'img4');
            } else {
                $data['img4'] = $productDetail->img4;
            }

            $productDetail->update($data);

            return ResponseHelper::sendSuccess('Product detail updated successfully', $productDetail, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Failed to update product detail', $th->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductDetail $productDetail)
    {
        try {
            $is_admin = TokenAuth::isAdmin(request());

            if (!$is_admin) {
                return ResponseHelper::sendError('You are not authorized to perform this action', null, 403);
            }

            unlink(public_path($productDetail->img1));
            unlink(public_path($productDetail->img2));
            unlink(public_path($productDetail->img3));
            unlink(public_path($productDetail->img4));
            $productDetail->delete();

            return ResponseHelper::sendSuccess('Product detail deleted successfully', null, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Failed to delete product detail', $th->getMessage(), 500);
        }
    }
}