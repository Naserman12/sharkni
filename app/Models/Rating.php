<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'rater_id', 'rated_user_id',
        'borrow_request_id', 'rating', 'comment'];
        public function rater(){
            return $this->belongsTo(User::class, 'rater_id');
        }
        public function ratedUser(){
            return $this->belongsTo(User::class, 'rated_user_id');
        }
        public function borrowRequest(){
            return $this->belongsTo(BorrowRequest::class);
        }
}
