<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\ResponseHandler;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    private $respHandler;

    public function __construct()
    {
        $this->respHandler = new ResponseHandler();
    }

    public function show($orderID)
    {
        /// Check transaction based on order id
        if (Transaction::where('order_id', $orderID)->first()) {

            /// Generate transaction and success response
            $transaction = Transaction::where('order_id', $orderID)->first();
            return $this->respHandler->send(200, "Successfuly Get Transaction", new TransactionResource($transaction));

        } else {
            /// Generate not found response
            $this->respHandler->notFound("Transaction");
        }
    }
}
