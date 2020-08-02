<?php

namespace App\Http\Controllers;

use App\FoodIngredient;
use App\ResponseHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FoodIngredientController extends Controller
{
    private $foodIngredient;
    private $respHandler;

    public function __construct()
    {
        $this->foodIngredient = new FoodIngredient();
        $this->respHandler = new ResponseHandler();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|min:4|max:255'
        ]);

        if ($validate->fails()) {
            return $this->respHandler->validateError($validate->errors());
        }

        $input = $request->all();

        if (!$this->foodIngredient->isExists($request->name)) {
            $createData = $this->foodIngredient->create($input);

            if ($createData) {
                return $this->respHandler->send(200, "Successfully Create Food Ingredient");
            }
            else {
                return $this->respHandler->internalError();
            }
        }
        else {
            return $this->respHandler->exists("Food Ingredient");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|min:4|max:255'
        ]);

        if ($validate->fails()) {
            return $this->respHandler->validateError($validate->errors());
        }

        $input = $request->all();

        if ($this->foodIngredient->isExistsById($id)) {
            $foodIngredient = $this->foodIngredient->find($id);
            $updateData = $foodIngredient->update($input);

            if ($updateData) {
                return $this->respHandler->send(200, "Successfully Update Food Ingredient");
            }
            else {
                return $this->respHandler->internalError();
            }
        }
        else {
            return $this->respHandler->notFound("Food Ingredient");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->foodIngredient->isExistsById($id)) {
            $foodIngredient = $this->foodIngredient->find($id);
            $foodIngredient->delete();
            return $this->respHandler->send(200, "Successfuly Delete Food");
        }
        else {
            $this->respHandler->notFound("Food");
        }
    }
}
