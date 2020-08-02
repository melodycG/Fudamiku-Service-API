<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $table = 'public.payments';

    protected $fillable = ['transaction_id', 'uuid', 'midtrans_data'];

    public function transaction()
    {
        return $this->belongsTo('App\Transaction');
    }
}
