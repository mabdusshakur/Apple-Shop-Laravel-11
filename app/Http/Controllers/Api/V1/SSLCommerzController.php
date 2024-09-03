<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ResponseHelper;
use App\Helpers\SSLCommerz;
use App\Http\Controllers\Controller;
use App\Models\SslcommerzCredential;
use Illuminate\Http\Request;

class SSLCommerzController extends Controller
{
    public function storeCredentials(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'store_id' => 'required',
                'store_passwd' => 'required',
                'currency' => 'required',
                'success_url' => 'required',
                'fail_url' => 'required',
                'cancel_url' => 'required',
                'ipn_url' => 'required',
                'init_url' => 'required',
            ]);
            SslcommerzCredential::updateOrCreate(['id' => 1], $request->all());
            return ResponseHelper::sendSuccess('SSLCommerz credentials updated successfully', null, 200);
        } catch (\Throwable $th) {
            return ResponseHelper::sendError('Internal server error', $th->getMessage(), 500);
        }
    }

    public function paymentSuccess(Request $request)
    {
        SSLCommerz::InitiateSuccess($request->tran_id);
        return redirect('/profile');
    }

    public function paymentFail(Request $request)
    {
        SSLCommerz::InitiateFail($request->tran_id);
        return redirect('/profile');
    }

    public function paymentCancel(Request $request)
    {
        SSLCommerz::InitiateCancel($request->tran_id);
        return redirect('/profile');
    }

    public function paymentIpn(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $status = $request->input('status');
        $val_id = $request->input('val_id');
        return SSLCommerz::InitiateIPN($tran_id, $status, $val_id);
    }
}