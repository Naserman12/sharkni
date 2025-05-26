<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//  المعاملات المالية
// يدعم تتبع المدفوعات )( تامين, إجار الخ...)
class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'borrow_request_id', 'amount',
         'type', 'status', 'payment_geteway_id'
    ];   
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function borrowRequest(){
        return $this->belongsTo(BorrowRequest::class);
    }
}   
