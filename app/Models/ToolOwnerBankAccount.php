<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolOwnerBankAccount extends Model
{
 protected $fillable = [
    'user_id', 'bank_name', 'account_number', 'account_holder_name'
 ];

//  العلاقة مع المالك
public function user(){
    return $this->belongsTo(User::class);
}
}
