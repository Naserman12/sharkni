<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    protected $fillable = [
        'user_id', 'tool_id', 'rental_id', 'amount', 'deposit_amount',
        'rental_amount', 'processing_fee','payment_type','status',
        'transaction_id','payment_method','proof_of_payment','delivery_code',
        'is_delivered','refund_status',
    ];

    // العلاقات مع المستخدم(المستاجر)
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    // العلاقة مع الاداة
    public function tool(){
        return $this->belongsTo(Tool::class);
    }
    // العلاقة مع طلب الإجار
    public function renta(){
        return $this->belongsTo(Rental::class);
    }
}
