<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    public $table = 'public.foods';

    protected $fillable = ['name', 'score', 'description', 'price', 'picture'];

    public function foodIngredient()
    {
        return $this->hasMany('App\FoodIngredient');
    }

    public function order()
    {
        return $this->hasMany('App\Order');
    }
}
