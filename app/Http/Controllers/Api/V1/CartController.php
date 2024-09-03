<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ResponseHelper;
use App\Helpers\TokenAuth;
use App\Models\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        try {
            // Get the customer id from the request
            $customer_id = TokenAuth::getCustomerId($req);

            $data = Cart::where('customer_id', $customer_id)->with('product')->get();

            return ResponseHelper::sendSuccess('Cart retrieved successfully', $data, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Internal server error, during Cart Retrieval', $th->getMessage(), 500);
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
    public function store(StoreCartRequest $request)
    {
        try {
            // Get the customer id from the request
            $customer_id = TokenAuth::getCustomerId($request);

            // Merge the user id with the request data
            $data = $request->merge(['customer_id' => $customer_id])->all();

            $cart = Cart::updateOrCreate(
                ['product_id' => $data['product_id'], 'customer_id' => $data['customer_id']],
                $data
            );

            if (!$cart) {
                return ResponseHelper::sendError('Failed to add product to cart', null, 400);
            }

            return ResponseHelper::sendSuccess('Product added to cart successfully', $cart, 201);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Internal server error, during Add Cart Operation', $th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Cart $cart)
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
            $cart = Cart::where('customer_id', $customer_id)->where('product_id', $product_id)->delete();
            return ResponseHelper::sendSuccess('Product removed from cart successfully', null, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Internal server error, during Remove Cart Item Operation', $th->getMessage(), 500);
        }
    }
}