<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ResponseHelper;
use App\Helpers\TokenAuth;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|integer',
            'remark' => 'nullable|string',
            'brand_id' => 'nullable|string',
        ]);

        $category_id = $request->input('category_id');
        $remark = $request->input('remark');
        $brand_id = $request->input('brand_id');

        if ($category_id) {
            $products = Product::where('category_id', $category_id)->with('brand', 'category', 'productDetail:id,product_id')->get();
        } elseif ($remark) {
            $products = Product::where('remark', 'like', "%$remark%")->with('brand', 'category', 'productDetail:id,product_id')->get();
        } elseif ($brand_id) {
            $products = Product::where('brand_id', $brand_id)->with('brand', 'category', 'productDetail:id,product_id')->get();
        } else {
            $products = Product::all()->load('brand', 'category', 'productDetail:id,product_id');
        }

        return ResponseHelper::sendSuccess('Products retrieved successfully', $products, 200);
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
    public function store(StoreProductRequest $request)
    {
        try {
            $is_admin = TokenAuth::isAdmin($request);

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

            $product = Product::create($data);
            if (!$product) {
                return ResponseHelper::sendError('Failed to create product', null, 500);
            }

            return ResponseHelper::sendSuccess('Product created successfully', $product, 201);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Failed to create product', $th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        try {
            $data = Product::with('brand', 'category', 'productDetail')->find($product->id);
            if (!$data) {
                return ResponseHelper::sendError('Product not found', null, 404);
            }
            return ResponseHelper::sendSuccess('Product retrieved successfully', $data, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Failed to retrieve product', $th->getMessage(), 500);
        }
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
        try {
            $is_admin = TokenAuth::isAdmin($request);

            if (!$is_admin) {
                return ResponseHelper::sendError('You are not authorized to perform this action', null, 403);
            }

            $data = $request->all();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/images'), $image_name);
                $data['image'] = 'uploads/images/' . $image_name;
                if ($product->image && file_exists(public_path($product->image))) {
                    unlink(public_path($product->image));
                }
            } else {
                $data['image'] = $product->image;
            }

            $product->update($data);
            if (!$product) {
                return ResponseHelper::sendError('Failed to update product', null, 500);
            }

            return ResponseHelper::sendSuccess('Product updated successfully', $product, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Failed to update product', $th->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $is_admin = TokenAuth::isAdmin(request());

            if (!$is_admin) {
                return ResponseHelper::sendError('You are not authorized to perform this action', null, 403);
            }
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $product->delete();
            return ResponseHelper::sendSuccess('Product deleted successfully', null, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Failed to delete product', $th->getMessage(), 500);
        }
    }
}