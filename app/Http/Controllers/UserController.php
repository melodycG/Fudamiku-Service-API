<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\ResponseHandler;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
	private $user;
    private $respHandler;

    public function __construct()
    {
        $this->user = new User();
        $this->respHandler = new ResponseHandler();
    }

    public function show($id)
    {
    	$user = $this->user->find($id);

    	return $this->respHandler->send(200, "Successfuly Get User", new UserResource($user));
    }
}
