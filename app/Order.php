<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = 'public.orders';

    protected $fillable = ['user_id', 'food_id', 'uuid', 'quantity', 'status'];

    public function transaction()
    {
        return $this->hasOne('App\Transaction');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function food()
    {
        return $this->belongsTo('App\Food');
    }
}
