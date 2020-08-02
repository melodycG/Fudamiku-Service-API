<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\ResponseHandler;
use App\Transaction;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class TransactionController extends Controller
{
    private $transaction;
    private $respHandler;

    public function __construct()
    {
        $this->transaction = new Transaction();
        $this->respHandler = new ResponseHandler();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($orderId)
    {
        if ($this->transaction->isExistsByOrderId($orderId)) {
            $transaction = $this->transaction->where('order_id', $orderId)->get();
            return $this->respHandler->send(200, "Successfuly Get Transaction", TransactionResource::collection($transaction));
        }
        else {
            $this->respHandler->notFound("Transaction");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['uuid'] = Uuid::generate(4);

        $createTransaction = $this->transaction->create($input);

        if ($createTransaction) {
            return $this->respHandler->send(200, "Successfully Create Transaction");
        }
        else {
            return $this->respHandler->internalError();
        }
    }
}
