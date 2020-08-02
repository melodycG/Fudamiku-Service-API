<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ResponseHandler;
use App\FileManager;
use App\Food;
use App\Http\Resources\FoodResource;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{
    private $food;
    private $respHandler;
    private $fileManager;

    public function __construct()
    {
        $this->food = new Food();
        $this->respHandler = new ResponseHandler();
        $this->fileManager = new FileManager();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foods = $this->food->with('foodIngredient')->get();

        if ($foods->count() > 0) {
            return $this->respHandler->send(200, "Successfuly Get Foods", FoodResource::collection($foods));
        }
        else {
            return $this->respHandler->notFound("Foods");
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
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|min:4|max:255',
            'score' => 'required',
            'description' => 'required|min:10|string',
            'price' => 'required|numeric',
            'picture' => 'required|image|max:5000'
        ]);

        if ($validate->fails()) {
            return $this->respHandler->validateError($validate->errors());
        }

        $input = $request->all();

        if (!$this->food->isExists($request->name)) {
            $path = $this->fileManager->saveData($request->file('picture'), $request->name, '/images/foods/');
            $input['picture'] = $path;

            $createData = $this->food->create($input);

            if ($createData) {
                return $this->respHandler->send(200, "Successfully Create Food");
            }
            else {
                return $this->respHandler->internalError();
            }
        }
        else {
            return $this->respHandler->exists("Food");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($this->food->isExistsById($id)) {
            $food = $this->food->find($id);
            return $this->respHandler->send(200, "Successfuly Get Food", new FoodResource($food));
        }
        else {
            $this->respHandler->notFound("Food");
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
            'name' => 'required|string|min:4|max:255',
            'score' => 'required',
            'description' => 'required|min:10|string',
            'price' => 'required|numeric',
            'picture' => 'image|max:5000'
        ]);

        if ($validate->fails()) {
            return $this->respHandler->validateError($validate->errors());
        }

        $input = $request->all();

        if ($this->food->isExistsById($id)) {
            $food = $this->food->find($id);

            if ($request->has('picture')) {
                $this->fileManager->removeData($food->picture);
                $path = $this->fileManager->saveData($request->file('picture'), $request->name, '/images/foods/');
                $input['picture'] = $path;
            }

            $updateData = $food->update($input);

            if ($updateData){
                return $this->respHandler->send(200, "Successfuly Update Food");
            }
            else {
                return $this->respHandler->internalError();
            }
        }
        else {
            $this->respHandler->notFound("Food");
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
        if ($this->food->isExistsById($id)) {
            $food = $this->food->find($id);
            $food->delete();
            return $this->respHandler->send(200, "Successfuly Delete Food");
        }
        else {
            $this->respHandler->notFound("Food");
        }
    }
}
