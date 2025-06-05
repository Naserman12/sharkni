<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'tool_id', 'rental_id', 'amount', 'deposit_amount',
        'rental_amount', 'processing_fee','payment_type','status',
        'transaction_id','payment_method','proof_of_payment','delivery_code',
        'is_delivered','refund_status',
    ];

    // الحالات ثوابت
    const STATUS_PENDIN = 'pending';
    const STATUS_FAILED = 'failed';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_AWAITING_COMFIRMATION = 'awaiting_comfirmation';
    const STATUS_DELIVERED = 'delivered';

    // طرق الدف
    const METHOD_PAYSTACK = 'paystack';
    const METHOD_BANK_TRANSFER = 'bank_transfer';

    // العلاقات مع المستخدم(المستاجر)
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    // العلاقة مع الاداة
    public function tool(){
        return $this->belongsTo(Tool::class);
    }
    // العلاقة مع طلب الإجار
    public function rental(){
        return $this->belongsTo(Rental::class);
    }
    public function paystackTransaction(){
        return $this->hasOne(PaystackTransaction::class, 'payment_id');
    }
}
