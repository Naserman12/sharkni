<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaystackTransaction extends Model{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'reference',
        'email',
        'metadata',
        'customer',
        'paid_at',
        'gateway_response',
    ];

    protected $casts =[
        'metadata' => 'array',
        'customer' => 'array',
        'paid_at' => 'datetime',
    ];
    public function payment(){
        return $this->belongsTo(payment::class);
    }
}
