<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class ResponseHandler extends Model
{
    public function authenticate($status = 200, $message, $token, $user)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'token' => $token,
            'user' => $user
        ], Response::HTTP_OK);
    }

    public function send($status = 200, $message, $data= [])
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function notFound($message)
    {
        return response()->json([
            'status' => 404,
            'message' => "$message not found"
        ], Response::HTTP_NOT_FOUND);
    }

    public function internalError()
    {
        return response()->json([
            'status' => 500,
            'message' => "Internal Server"
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function exists($message)
    {
        return response()->json([
            'status' => 400,
            'message' => "$message Already Exist"
        ], Response::HTTP_BAD_REQUEST);
    }

    public function validateError($errors)
    {
        return response()->json([
            'status' => 422,
            'message' =>'Validation Errors',
            'errors' => $errors
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function badCredential()
    {
        return response()->json([
            'status' => 401,
            'message' => 'Username or Password is Wrong'
        ], Response::HTTP_UNAUTHORIZED);
    }
}
