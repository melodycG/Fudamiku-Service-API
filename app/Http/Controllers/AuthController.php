<?php

namespace App\Http\Controllers;

use App\User;
use App\FileManager;
use App\ResponseHandler;
use Webpatser\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $respHandler;
    private $fileManager;

    public function __construct()
    {
        $this->respHandler = new ResponseHandler();
        $this->fileManager = new FileManager();
    }

    public function register(Request $request)
    {
        /// Validate all request
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|string',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string',
            'phone_number' => 'required|numeric|unique:users,phone_number',
            'address' => 'required',
            'house_number' => 'required',
            'city' => 'required',
            'photo' => 'image|max:5000'
        ]);

        /// Check if validation is fails
        if($validate->fails()) {
            return $this->respHandler->validateError($validate->errors());
        }

        /// Check if email hasn't registered
        if (!User::where('email', $request->email)->first()) {

            /// Create new user data
            $user = User::create([
                'uuid' => Uuid::generate(4)->string,
                'name'=> $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'house_number' => $request->house_number,
                'city' => $request->city,
            ]);

            /// Check if request has photo file
            if ($request->has('photo')) {
                $this->fileManager->saveData($request->file('photo'), $user->name, '/images/users/');
                $user->photo = '/images/users/' . $this->fileManager->fileResult;
            }

            /// Store user attribute model
            $user->save();

            /// Generate token and success response
            $token = $user->createToken('nApp')->accessToken;
            return $this->respHandler->authenticate(200, "Success Sign Up", $token, new UserResource($user));

        } else {
            /// Generate user exists response
            return $this->respHandler->exists("User");
        }
    }

    public function login(Request $request)
    {
        /// Validate login request
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        /// Check if validation is fails
        if($validate->fails()) {
            return $this->respHandler->validateError($validate->errors());
        }

        /// Declaring credentials data from request
        $credentials = $request->only('email', 'password');

        /// Checking credentials data via api guard
        if (Auth::guard('web')->attempt($credentials)) {

            /// Generate token and success response
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('nApp')->accessToken;
            return $this->respHandler->authenticate(200, "Success Sign In", $token, new UserResource($user));

        } else {
            // Generate bad credentials response
            return $this->respHandler->badCredential();
        }
    }
}
