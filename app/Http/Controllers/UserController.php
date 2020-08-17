<?php

namespace App\Http\Controllers;

use App\User;
use App\FileManager;
use App\ResponseHandler;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $respHandler;
    private $fileManager;

    public function __construct()
    {
        $this->respHandler = new ResponseHandler();
        $this->fileManager = new FileManager();
    }

    public function show($id)
    {
        /// Find user by id
    	$user = User::find($id);

        /// Generate user resource and success response
    	return $this->respHandler->send(200, "Successfuly Get User", new UserResource($user));
    }

    public function update(Request $request, $id)
    {
        /// Validate all request
        $validate = Validator::make($request->all(), [
            'name' => 'string|max:255|min:3',
            'phone_number' => 'numeric|unique:users,phone_number,' . $id,
            'photo' => 'image|max:5000'
        ]);

        /// Check if validation is fails
        if($validate->fails()) {
            return $this->respHandler->validateError($validate->errors());
        }

        /// Check if user id is exists
        if (User::find($id)) {

            /// Set model attribute to request
            $user = User::find($id);
            $user->name = $request->name;
            $user->phone_number = $request->phone_number;
            $user->address = $request->address;
            $user->house_number = $request->house_number;
            $user->city = $request->city;

            /// Check if request has photo file
            if ($request->has('photo')) {
                
                /// Store new photo file
                $this->fileManager->saveData($request->file('photo'), $user->name, '/images/users/');
                $user->photo = '/images/users/' . $this->fileManager->fileResult;
            }

            /// Update user attribute model
            $user->save();

            /// Generate success response
            return $this->respHandler->send(200, "Successfully Update User");

        } else {
            /// Generate not found response
            return $this->respHandler->notFound("Food");
        }
    }
}
