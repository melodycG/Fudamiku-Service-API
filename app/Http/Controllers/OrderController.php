<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Order;
use App\ResponseHandler;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class OrderController extends Controller
{
    private $order;
    private $respHandler;

    public function __construct()
    {
        $this->order = new Order();
        $this->respHandler = new ResponseHandler();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {
        if ($this->order->isExistsByUserId($userId)) {
            $order = $this->order->where('user_id', $userId)->get();
            return $this->respHandler->send(200, "Successfuly Get Order", OrderResource::collection($order));
        }
        else {
            $this->respHandler->notFound("Order");
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

        $createOrder = $this->order->create($input);

        if ($createOrder) {
            return $this->respHandler->send(200, "Successfully Create Order");
        }
        else {
            return $this->respHandler->internalError();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $order = $this->order->find($id);
        $updateStatus = $order->update(['status' => $request->status]);

        if ($updateStatus) {
            return $this->respHandler->send(200, "Successfully Update Status Order");
        }
        else {
            return $this->respHandler->internalError();
        }
    }
}
