<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// يدعم التعامل مع الاضرار عبر تخزين الصور وتفاصيل التقرير
class DamageReport extends Model
{
    protected $fillable =[
        'borrow_request_id', 'description', 'image_paths', 
        'status', 'resolution_amount'];
    protected $casts =[ 'image_paths' => 'array',];
    public function borrowRequest(){
        return $this->belongsTo(BorrowRequest::class);
    }

}
