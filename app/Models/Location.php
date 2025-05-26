<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name', 'name_ha', 'coordinates'
    ];
    public function tools(){
        return $this->belongsToMany(Tool::class, 'tool_location');
    }
    public function getNameAttribute(){
        return app()->getLocale() == 'ha' && $this->name_ha ? $this->name_ha : $this->name;
    }
}
