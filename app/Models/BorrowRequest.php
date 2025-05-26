<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BorrowRequest extends Model
{
    protected $fillable = [
        'tool_id', 'borrower_id', 'lender_id', 'status', 'borrow_date',
        'return_date', 'damage_report_id', 'is_paid', 'total_cost',
        'deposit_paid', 'deposit_status'
    ];

    protected $casts =[
        'is_paid' => 'boolean',
        'borrow_date' => 'datetime',
        'return_date' => 'datetime'
    ];

    public function tool(){
        return $this->belongsTo(Tool::class);
    }
    public function borrower(){
        return $this->belongsTo(User::class, 'borrower_id');
    }
    public function lender(){
     return $this->belongsTo(User::class, 'lender_id');
    }
    public function damageReport(){
        return $this->hasMany(DamageReport::class);
    }
    public function ratings(){
        return $this->hasMany(Rating::class);
    }
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
    public function messages(){
        return $this->hasMany(Message::class);
    }
}
