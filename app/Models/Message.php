<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// المحادثات داخل الموفع
class Message extends Model
{
    protected $fillable = [
        'sender_id', 'receiver_id', 'borrow_request_id','content', 'content_ha', 'read_at'
    ];
    protected $casts =[
        'read_at' => 'datetime'
    ];
    public function  sender(){
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function  receiver(){
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function  borrowRequest(){
        return $this->belongsTo(BorrowRequest::class);
    }
    public function  getContentAttribute(){
        return app()->getLocale() == 'ha' && $this->content_ha ? $this->content_ha : $this->content;
    }
}
