<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PDO;

class Comment extends Model
{
    protected $fillable =[
        'tool_id',
        'user_id',
        'content',
    ];
    public function tool(){
        return $this->belongsTo(Tool::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
