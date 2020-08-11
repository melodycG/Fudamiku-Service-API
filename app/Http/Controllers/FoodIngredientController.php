<?php

namespace App\Http\Controllers;

use App\FoodIngredient;
use App\ResponseHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\FoodIngredientResource;

class FoodIngredientController extends Controller
{
    private $respHandler;

    public function __construct()
    {
        $this->respHandler = new ResponseHandler();
    }

    public function show($id)
    {
        /// Check if food ingredient is exists
        if (FoodIngredient::find($id)) {

            /// Generate food and success response
            $foodIngredient = FoodIngredient::find($id);
            return $this->respHandler->send(200, "Successfuly Get Food Ingredient", new FoodIngredientResource($foodIngredient));

        } else {
            /// Generate not found response
            return $this->respHandler->notFound("Food Ingredient");
        }
    }

    public function update(Request $request, $id)
    {
        /// Validate name request
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|min:4|max:255'
        ]);

        /// Check if validation is fails
        if ($validate->fails()) {
            return $this->respHandler->validateError($validate->errors());
        }

        if (FoodIngredient::find($id)) {

            /// Set model attribute to request
            $foodIngredient = FoodIngredient::find($id);
            $foodIngredient->food_id = $request->food_id;
            $foodIngredient->name = $request->name;
            $foodIngredient->save();

            /// Generate success response
            return $this->respHandler->send(200, "Successfully Update Food Ingredient");

        } else {
            /// Generate not found response
            return $this->respHandler->notFound("Food Ingredient");
        }
    }

    public function destroy($id)
    {
        /// Check if food id is exists
        if (FoodIngredient::find($id)) {

            /// Deleting food data and generate success response
            FoodIngredient::destroy($id);
            return $this->respHandler->send(200, "Successfuly Delete Food Ingredient");

        } else {
            /// Generate not found response
            return $this->respHandler->notFound("Food Ingredient");
        }
    }
}
