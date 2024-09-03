<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ResponseHelper;
use App\Helpers\TokenAuth;
use App\Models\Wishlist;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWishlistRequest;
use App\Http\Requests\UpdateWishlistRequest;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Get the customer id from the request
            $customer_id = TokenAuth::getCustomerId($request);

            $data = Wishlist::where('customer_id', $customer_id)->with('product')->get();

            return ResponseHelper::sendSuccess('Wishlist retrieved successfully', $data, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Internal server error, during Wishlist Retrieval', $th->getMessage(), 500);
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
    public function store(StoreWishlistRequest $request)
    {
        try {
            // Get the customer id from the request
            $customer_id = TokenAuth::getCustomerId($request);

            // Merge the user id with the request data
            $data = $request->merge(['customer_id' => $customer_id])->all();

            $wishlist = Wishlist::updateOrCreate(
                ['product_id' => $data['product_id'], 'customer_id' => $data['customer_id']],
                $data
            );

            if (!$wishlist) {
                return ResponseHelper::sendError('Failed to add product to wishlist', null, 400);
            }

            return ResponseHelper::sendSuccess('Product added to wishlist successfully', $wishlist, 201);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Internal server error', null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWishlistRequest $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($product_id)
    {
        try {
            // Get the customer id from the request
            $customer_id = TokenAuth::getCustomerId(request());
            $wishlist = Wishlist::where('product_id', $product_id)->where('customer_id', $customer_id)->delete();
            return ResponseHelper::sendSuccess('Product removed from wishlist successfully', null, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Internal server error', null, 500);
        }
    }
}