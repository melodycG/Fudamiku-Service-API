<?php

namespace App\Http\Controllers;

use App\Food;
use App\FileManager;
use App\FoodIngredient;
use App\ResponseHandler;
use Illuminate\Http\Request;
use App\Http\Resources\FoodResource;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{
    private $respHandler;
    private $fileManager;

    public function __construct()
    {
        $this->respHandler = new ResponseHandler();
        $this->fileManager = new FileManager();
    }

    public function index()
    {
        /// Get all food and ingredient data
        $foods = Food::all();

        /// Check if no one food found
        if ($foods->count() > 0) {
            /// Generate success response
            return $this->respHandler->send(200, "Successfuly Get Foods", FoodResource::collection($foods));
        } else {
            /// Generate not found response
            return $this->respHandler->notFound("Foods");
        }
    }

    public function store(Request $request)
    {
        /// Validate all request
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|min:4|max:255',
            'score' => 'required',
            'description' => 'required|min:10|string',
            'price' => 'required|numeric',
            'picture' => 'required|image|max:5000'
        ]);

        /// Check if validation is fails
        if ($validate->fails()) {
            return $this->respHandler->validateError($validate->errors());
        }

        /// Check if food name isn't exists
        if (!Food::where('name', $request->name)->first()) {

            /// Set model attribute to request
            $food = new Food;
            $food->name = $request->name;
            $food->score = $request->score;
            $food->description = $request->description;
            $food->price = $request->price;

            /// Save picture file and set path
            $this->fileManager->saveData($request->file('picture'), $request->name, '/images/foods/');
            $food->picture = '/images/foods/' . $this->fileManager->fileResult;
            $food->save();

            /// Declare variable array container
            $foodIngredient = [];

            /// Mapping food ingredient each to variable above
            foreach($request->ingredients as $ingredient) {
                $foodIngredient[] = new FoodIngredient([
                    'food_id' => $request->food_id,
                    'name' => $ingredient,
                ]);
            }

            /// Save to food ingredient model
            $food->foodIngredient()->saveMany($foodIngredient);

            /// Generate success response
            return $this->respHandler->send(200, "Successfully Create Food");

        } else {
            /// Generate food exists response
            return $this->respHandler->exists("Food");
        }
    }

    public function show($id)
    {
        /// Check if food id is exists
        if (Food::find($id)) {

            /// Generate food and success response
            $food = Food::find($id);
            return $this->respHandler->send(200, "Successfuly Get Food", new FoodResource($food));

        } else {
            /// Generate not found response
            return $this->respHandler->notFound("Food");
        }
    }

    public function update(Request $request, $id)
    {
        /// Validate all request
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|min:4|max:255',
            'score' => 'required',
            'description' => 'required|min:10|string',
            'price' => 'required|numeric',
            'picture' => 'image|max:5000'
        ]);

        /// Check if validation is fails
        if ($validate->fails()) {
            return $this->respHandler->validateError($validate->errors());
        }

        /// Check if food id is exists
        if (Food::find($id)) {

            /// Set model attribute to request
            $food = Food::find($id);
            $food->name = $request->name;
            $food->score = $request->score;
            $food->description = $request->description;
            $food->price = $request->price;

            /// Check if has picture image
            if ($request->has('picture')) {
                $this->fileManager->saveData($request->file('picture'), $request->name, '/images/foods/');
                $food->picture = '/images/foods/' . $this->fileManager->fileResult;
            }

            /// Update food attribute model
            $food->save();

            /// Declare variable array container
            $foodIngredient = [];

            /// Mapping food ingredient each to variable above
            foreach($request->ingredients as $ingredient) {
                $foodIngredient[] = new FoodIngredient([
                    'food_id' => $request->food_id,
                    'name' => $ingredient,
                ]);
            }

            /// Save to food ingredient model
            $food->foodIngredient()->saveMany($foodIngredient);

            /// Generate success response
            return $this->respHandler->send(200, "Successfully Update Food");
            
        } else {
            /// Generate not found response
            return $this->respHandler->notFound("Food");
        }
    }

    public function destroy($id)
    {
        /// Check if food id is exists
        if (Food::find($id)) {

            /// Deleting food picture file
            $food = Food::find($id);
            $this->fileManager->removeData($food->picture);

            /// Deleting food data and generate success response
            Food::destroy($id);
            return $this->respHandler->send(200, "Successfuly Delete Food");

        } else {
            /// Generate not found response
            return $this->respHandler->notFound("Food");
        }
    }
}
