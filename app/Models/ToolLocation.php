<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolLocation extends Model
{
    protected $fillable = [
        'tool_id', 'location_id'
    ];
    public function tool(){
        return $this->belongsTo(Tool::class);
    }
    public function location(){
        return $this->belongsTo(Location::class);
    }
}
