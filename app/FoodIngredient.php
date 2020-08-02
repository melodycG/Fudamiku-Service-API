<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodIngredient extends Model
{
    public $table = 'public.food_ingredients';

    protected $fillable = ['food_id', 'name'];

    public function food()
    {
        return $this->belongsTo('App\Food');
    }

    public function isExists($name)
    {
        $data = $this->where('name', $name)->first();

        if ($data) {
            return true;
        } else {
            return false;
        }
    }

    public function isExistsById($id)
    {
        $data = $this->find($id);

        if ($data) {
            return true;
        } else {
            return false;
        }
    }
}
