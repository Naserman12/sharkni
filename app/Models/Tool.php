<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'name', 'description', 'price',
        'is_free', 'deposit_amount', 'status', 'condition', 'image_paths', 'location',
    ];

    protected  $casts = [
        'image_paths' => 'array',
        'is_free' => 'boolean',
        'price' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
    ];

    # العلاقات
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
      }
    public function borrowRequests(){
        return $this->hasMany(BorrowRequest::class);
    }
    public function rentals(){
        return $this->hasMany(Rental::class);
    }
      
    public function locations(){
        return $this->belongsToMany(Location::class, 'tool_location');
    }
}
