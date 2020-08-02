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
