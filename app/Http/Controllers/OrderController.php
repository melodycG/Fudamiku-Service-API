<?php

namespace App\Http\Controllers;

use App\Order;
use App\Transaction;
use App\ResponseHandler;
use Webpatser\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    private $respHandler;

    public function __construct()
    {
        $this->respHandler = new ResponseHandler();
    }

    public function show($userID)
    {
        /// Check if user's order is exists
        if (Order::where('user_id', $userID)->get()) {

            /// Generate order and success response
            $order = Order::where('user_id', $userID)->get();
            return $this->respHandler->send(200, "Successfuly Get Order", OrderResource::collection($order));

        } else {
            /// Generate not found response
            return $this->respHandler->notFound("Order");
        }
    }

    public function store(Request $request)
    {
        /// Set and store new order data
        $order = new Order;
        $order->user_id = $request->user_id;
        $order->food_id = $request->food_id;
        $order->uuid = Uuid::generate(4)->string;
        $order->quantity = $request->quantity;
        $order->status = $request->status;
        $order->save();

        /// Set and store new transaction data
        $transaction = new Transaction;
        $transaction->order_id = $order->id;
        $transaction->user_id = $request->user_id;
        $transaction->uuid = Uuid::generate(4)->string;
        $transaction->delivery_service = $request->delivery_service;
        $transaction->tax = $request->tax;
        $transaction->total_price = $request->total_price;
        $transaction->save();

        /// Generate success response
        return $this->respHandler->send(200, "Successfully Create Order");
    }

    public function updateStatus(Request $request, $id)
    {
        /// Check if order id is exists
        if (Order::find($id)) {

            /// Set new order status
            $order = Order::find($id);
            $order->update(['status' => $request->status]);

            /// Generate success response
            return $this->respHandler->send(200, "Successfully Update Status Order");

        } else {
            /// Generate not found response
            return $this->respHandler->notFound("Order");
        }
    }
}
