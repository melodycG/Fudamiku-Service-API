<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $table = 'public.transactions';

    protected $fillable = ['order_id', 'user_id', 'uuid', 'delivery_service', 'tax', 'total_price'];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
