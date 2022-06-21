<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Checkout;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
class ApiCheckoutController extends Controller
{
    public function getAllCheckouts()
    {
        $checkouts = Checkout::where('user_id', Auth::user()->id)->get();
  
        return response([
            "message" => "success get all orders",
            "checkout" => $checkouts,
            // "orders" => $orders
        ], 200);
    }

    public function getCheckout($id)
    {
        $checkout = Checkout::find($id);
        if (!$checkout) {
            return response([
                "message" => "checkout not found!"
            ], 200);
        }
        if ($checkout->user_id != Auth::user()->id) {
            return response([
                "message" => "Forbidden"
            ], 403);
        }

        return response([
            "message" => "success get checkout",
            "checkout" => $checkout
        ], 200);
    }

    public function createCheckout()
    {
        $checkout = Checkout::Create([
            'user_id' => Auth::user()->id,
            'tanggal_checkout' => date("Y-m-d"),
            'status' => "Menunggu Pembayaran",
            'total_harga' => 0,
            'paid_at' => null
        ]);

        return response([
            "message" => "success create checkout",
            "checkout" => $checkout
        ], 200);
    }

    public function updateCheckout($id)
    {
        $checkout = Checkout::find($id);
        if (!$checkout) {
            return response([
                "message" => "checkout not found!"
            ], 200);
        }
        if ($checkout->user_id != Auth::user()->role_id) {
            return response([
                "message" => "Forbidden"
            ], 403);
        }
        
        $validator = $request->validate([
            'status' => 'required|integer',
            'paid_at' => 'required|string'
        ]);

        $checkout->status = $request->status;

        if ($request->status == "Pembayaran Sukses") {
            $checkout->paid_at = date("Y-m-d");
        }
        
        $checkout->save();

        return response([
            "message" => "success update checkout",
            "checkout" => $checkout
        ], 200);
    }
}