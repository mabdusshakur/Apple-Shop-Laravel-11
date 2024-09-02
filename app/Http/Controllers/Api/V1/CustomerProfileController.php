<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ResponseHelper;
use App\Helpers\TokenAuth;
use App\Models\CustomerProfile;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerProfileRequest;
use App\Http\Requests\UpdateCustomerProfileRequest;

class CustomerProfileController extends Controller
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerProfileRequest $request)
    {
        try {
            // get the user id from the request
            $user_id = TokenAuth::getUserId($request);

            // merge the user id with the request data
            $data = $request->merge(['user_id' => $user_id])->all();

            $isExits = CustomerProfile::where('user_id', $user_id)->first();
            if ($isExits) {
                return ResponseHelper::sendError('Customer profile already exists, use Patch|Put For update profile', null, 400);
            }

            // create a new customer profile
            $customerProfile = CustomerProfile::create($data);

            if (!$customerProfile) {
                return ResponseHelper::sendError('Failed to create customer profile', null, 500);
            }
            return ResponseHelper::sendSuccess('Customer profile created successfully', $customerProfile, 201);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Failed to create customer profile', $th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerProfile $customerProfile)
    {
        try {
            $user_id = TokenAuth::getUserId(request());
            $customerProfile = CustomerProfile::where('user_id', $user_id)->first();
            if (!$customerProfile) {
                return ResponseHelper::sendError('Forbidden', null, 403);
            }
            return ResponseHelper::sendSuccess('Customer profile retrieved successfully', $customerProfile, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Failed to retrieve customer profile', $th->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerProfile $customerProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerProfileRequest $request, CustomerProfile $customerProfile)
    {
        try {
            $user_id = TokenAuth::getUserId(request());
            $customerProfile = CustomerProfile::where('user_id', $user_id)->first();
            if (!$customerProfile) {
                return ResponseHelper::sendError('Forbidden', null, 403);
            }

            $data = $request->all();
            $customerProfile->update($data);

            return ResponseHelper::sendSuccess('Customer profile updated successfully', $customerProfile, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Failed to update customer profile', $th->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerProfile $customerProfile)
    {
        //
    }
}