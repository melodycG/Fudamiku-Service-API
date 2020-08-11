<?php

namespace App\Http\Controllers;

use App\User;
use App\ResponseHandler;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    private $respHandler;

    public function __construct()
    {
        $this->respHandler = new ResponseHandler();
    }

    public function show($id)
    {
        /// Find user by id
    	$user = User::find($id);

        /// Generate user resource and success response
    	return $this->respHandler->send(200, "Successfuly Get User", new UserResource($user));
    }
}
