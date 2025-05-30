<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// يدعم التعامل مع الاضرار عبر تخزين الصور وتفاصيل التقرير
class DamageReport extends Model
{
    protected $fillable =[
        'rental_id', 'description', 'image_paths', 
        'status', 'resolution_amount'];
    protected $casts =[ 
        'image_paths' => 'array',
        'stauts' => 'string',
        'resolution_amount' => 'decimal',
    ];
    public function rental(){
        return $this->belongsTo(Rental::class, 'rental_id');
    }

}
