<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Order;
use App\Models\Checkout;
use App\Models\Tiket;
use Illuminate\Support\Facades\Auth;

class ApiOrderController extends Controller
{
    public function getAllOrders($cid)
    {
        $checkout = Checkout::find($cid);
        if (!$cid) {
            return response([
                "message" => "checkout not found!",
            ], 400);
        }

        if ($checkout->user_id != Auth::user()->id) {
            return response([
                "message" => "Forbidden!",
            ], 403);
        }

        $orders = Order::with(['checkout','tiket'])->where('checkout_id', '=', $cid)->get();
        if (!$orders) {
            return response([
                "message" => "orders not found!",
            ], 400);
        }
        
        return response([
            "message" => "success get all orders",
            "checkout" => $checkout,
            "orders" => $orders
        ], 200);
    }

    // public function getOrder($id) {
    //     $order = Order::with('checkout')->where($id);
    //     if (!$order) {
    //         return response([
    //             "message" => "order not found!",
    //         ], 400);
    //     }
    //     if ($cid->checkout->user_id != Auth::user()->id) {
    //         return response([
    //             "message" => "Forbidden!",
    //         ], 403);
    //     }
    //     return response([
    //         "message" => "success get order",
    //         "order" => $order
    //     ], 200);
    // }

    public function createOrder(Request $request) {
        $checkout = Checkout::Create([
            'user_id' => Auth::user()->id,
            'tanggal_checkout' => date("Y-m-d"),
            'status' => "Menunggu Pembayaran",
            'total_harga' => 0,
            'paid_at' => null
        ]);
        
        $total_harga = 0;
        $tickets = [];
        foreach ($request->orders as $order) 
        {   
            
            $tiket = Tiket::find($order["ticket_id"]);
            $tickets = array_merge($tickets, [$tiket]);
            $order = Order::Create([
                'checkout_id' => $checkout->id,
                'tiket_id' => $tiket->id,
                'quantity' => $order["quantity"],
            ]);
            $total_harga += $tiket->harga*$order["quantity"];
        }
       
        $checkout->total_harga = $total_harga;
        $checkout->save();
        return response([
            "checkout" => $checkout,
            "orders" => $tickets,
        ], 200);
    }
}
