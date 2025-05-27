<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'name_ha', 'slug'
    ];
    
    public function tools(){
        return $this->hasMany(Tool::class);
    }
    public function getLocalizedNameAttribute(){
        return app()->getLocale() == 'ha' ?  $this->name_ha :  $this->name;
    }
}
