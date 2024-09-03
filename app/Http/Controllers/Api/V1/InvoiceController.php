<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Cart;
use App\Models\Invoice;
use App\Helpers\TokenAuth;
use App\Helpers\SSLCommerz;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\CustomerProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\InvoiceProduct;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Invoice::where('customer_id', TokenAuth::getCustomerId($request))->get();
        return ResponseHelper::sendSuccess('Invoice list', $data, 200);
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
    public function store(StoreInvoiceRequest $request)
    {
        try {
            DB::beginTransaction();

            // Get the customer id from the request
            $customer_id = TokenAuth::getCustomerId($request);


            // Creating customer details
            $customer_profile = CustomerProfile::where('id', $customer_id)->first();
            if (!$customer_profile) {
                return ResponseHelper::sendError('Customer profile not found', null, 404);
            }

            $customer_info = [
                'name' => $customer_profile->cus_name,
                'phone' => $customer_profile->cus_phone,
                'address' => $customer_profile->cus_add,
                'city' => $customer_profile->cus_city,
                'state' => $customer_profile->cus_state,
                'country' => $customer_profile->cus_country,
                'postCode' => $customer_profile->cus_postcode,
            ];

            $ship_info = [
                'name' => $customer_profile->ship_name,
                'phone' => $customer_profile->ship_phone,
                'address' => $customer_profile->ship_add,
                'city' => $customer_profile->ship_city,
                'state' => $customer_profile->ship_state,
                'country' => $customer_profile->ship_country,
                'postCode' => $customer_profile->ship_postcode,
            ];

            // Get user email from the User table
            $user_email = $customer_profile->user->email;


            // Generating static invoice details
            $transaction_id = uniqid();
            $delivery_status = 'Pending';
            $payment_status = 'Pending';


            // Creating products array for sslcommerz
            $products = [
                'name' => [],
                'category' => [],
                'brand' => [],
            ];

            // Calculating total amount with Cart products dynamic price * quantity
            $total_amount = 0;
            $cartItems = Cart::where('customer_id', $customer_id)->with('product')->get();
            foreach ($cartItems as $cartItem) {

                // Getting product price with discount
                $product = $cartItem->product;
                $productPrice = $product->is_discount ? $product->discount_price : $product->price;
                $total_amount += $productPrice * $cartItem->quantity;

                // Pushing product details to products array
                array_push($products['name'], $product->title);
                array_push($products['category'], $product->category->name);
                array_push($products['brand'], $product->brand->name);
            }

            // Calculating payable amount with total amount + vat
            $vat = 3; // 3% VAT rate for now as hardcoded
            $vat_amount = ($total_amount * $vat) / 100;
            $payable_amount = $total_amount + $vat_amount;


            // Creating invoice
            $invoice = Invoice::create([
                'total' => $total_amount,
                'vat' => $vat_amount,
                'payable' => $payable_amount,
                'cus_details' => json_encode($customer_info),
                'ship_details' => json_encode($ship_info),
                'tran_id' => $transaction_id,
                'delivery_status' => $delivery_status,
                'payment_status' => $payment_status,
                'customer_id' => $customer_id,
            ]);


            if (!$invoice) {
                DB::rollBack();
                return ResponseHelper::sendError('Failed to create invoice', null, 500);
            }


            // Creating invoice products
            foreach ($cartItems as $cartItem) {
                InvoiceProduct::create([
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                    'product_id' => $cartItem->product_id,
                    'invoice_id' => $invoice->id,
                ]);
            }

            // generating sslcommerz invoice
            $paymentMethod = SSLCommerz::InitiatePayment($customer_profile, $products, $payable_amount, $transaction_id, $user_email);

            $data = [
                'payment_methods' => $paymentMethod,
                'payable' => $payable_amount,
                'vat' => $vat_amount,
                'total' => $total_amount,
            ];

            DB::commit();
            return ResponseHelper::sendSuccess('Invoice created successfully', $data, 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return ResponseHelper::sendError('Internal server error, during Invoice Creation', $th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        // Get the customer id from the request
        $customer_id = TokenAuth::getCustomerId(request());


        $invoice = Invoice::where('id', $invoice->id)->where('customer_id', $customer_id)->with('invoiceProducts', 'invoiceProducts.product')->get();
        return ResponseHelper::sendSuccess('Invoice details', $invoice, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}