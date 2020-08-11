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
}
