<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $table = 'public.transactions';

    protected $fillable = ['order_id', 'user_id', 'uuid', 'delivery_service', 'tax', 'total_price'];

    public function payment()
    {
        return $this->hasOne('App\Payment');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function isExistsByOrderId($orderId)
    {
        $data = $this->where('order_id', $orderId)->get();

        if ($data) {
            return true;
        } else {
            return false;
        }
    }
}
