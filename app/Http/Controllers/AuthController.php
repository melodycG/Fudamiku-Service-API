<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use App\ResponseHandler;
use App\FileManager;
use App\User;

class AuthController extends Controller
{
    private $user;
    private $respHandler;
    private $fileManager;

    public function __construct()
    {
        $this->user = new User();
        $this->respHandler = new ResponseHandler();
        $this->fileManager = new FileManager();
    }

    public function register(Request $request)
    {
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

        if($validate->fails()) {
            return $this->respHandler->validateError($validate->errors());
        }

        $input = $request->all();
        $user = $this->user->where('email', $input['email'])->first();

        if (!$user) {
            $input['uuid'] = Uuid::generate(4)->string;
            $input['password'] = Hash::make($input['password']);

            if ($request->has('photo')) {
                $input['path_photo'] = $this->fileManager->saveData($request->file('photo'), $input['name'], '/images/users/');
                $input['photo'] = '/images/users/' . $this->fileManager->fileResult;
            }

            $user = $this->user->create($input);

            $token = $user->createToken('nApp')->accessToken;
            return $this->respHandler->authenticate(200, "Success Sign Up", $token);
        }
        else {
            return $this->respHandler->exists("User");
        }
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validate->fails()) {
            return $this->respHandler->validateError($validate->errors());
        }

        $input = $request->all();
        $user = $this->user->where('email', $input['email'])->first();

        if ($user) {
            if (Hash::check($input['password'], $user->password)) {
                $token = $user->createToken('nApp')->accessToken;
                return $this->respHandler->authenticate(200, "Success Sign In", $token);
            }
            else {
                return $this->respHandler->badCredential();
            }
        }
        else {
            return $this->respHandler->notFound("Users");
        }
    }
}
