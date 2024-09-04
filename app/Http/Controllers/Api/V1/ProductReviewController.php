<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ResponseHelper;
use App\Helpers\TokenAuth;
use App\Models\ProductReview;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductReviewRequest;
use App\Http\Requests\UpdateProductReviewRequest;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
        ]);

        $product_id = $request->input('product_id');

        $productReviews = ProductReview::where('product_id', $product_id)->with('customerProfile:id,cus_name')->get();

        return ResponseHelper::sendSuccess('Product reviews retrieved successfully', $productReviews, 200);
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
    public function store(StoreProductReviewRequest $request)
    {
        try {
            // Get the customer id from the request
            $customer_id = TokenAuth::getCustomerId($request);

            // Merge the user id with the request data
            $data = $request->merge(['customer_id' => $customer_id])->all();

            // Check if the user has already reviewed the product
            $existingReview = ProductReview::where('customer_id', $customer_id)
                ->where('product_id', $request->input('product_id'))
                ->first();

            if ($existingReview) {
                // Update the existing review
                return $this->updateExistingReview($request);
            }

            // Create a new review
            $review = ProductReview::create($data);

            return response()->json(['message' => 'Review created successfully', 'review' => $review], 201);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Internal server error', null, 500);
        }
    }

    public function updateExistingReview($request)
    {
        try {
            // Get the customer id from the request
            $customer_id = TokenAuth::getCustomerId($request);

            // Merge the user id with the request data
            $data = $request->merge(['customer_id' => $customer_id])->all();

            // Check if the user has already reviewed the product
            $existingReview = ProductReview::where('customer_id', $customer_id)
                ->where('product_id', $request->input('product_id'))
                ->first();

            // Update the review
            $existingReview->update($data);

            return response()->json(['message' => 'Review updated successfully', 'review' => $existingReview], 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Internal server error', null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductReview $productReview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductReview $productReview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductReviewRequest $request, ProductReview $productReview)
    {
        try {
            // Get the customer id from the request
            $customer_id = TokenAuth::getCustomerId($request);

            // Merge the user id with the request data
            $data = $request->merge(['customer_id' => $customer_id])->all();

            $productReview->where('customer_id', $customer_id)
                ->where('product_id', $request->input('product_id'))
                ->update($data);

            return ResponseHelper::sendSuccess('Review updated successfully', null, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Internal server error', null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductReview $productReview)
    {
        try {
            // Get the customer id from the request
            $customer_id = TokenAuth::getCustomerId(request());

            $productReview->where('customer_id', $customer_id)->delete();
            return ResponseHelper::sendSuccess('Review deleted successfully', null, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Internal server error', null, 500);
        }
    }
}