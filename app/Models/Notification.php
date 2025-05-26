<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'useR_id', 'content', 'content_ha', 'type',
         'related_id', 'related_type', 'read_at'];
         protected $casts =[
            'read_at' => 'datetime',
         ];
         public function user(){
            return $this->belongsTo(User::class);
         }
         public function related(){
            // يدعم ربط الاشعارات بمختلف الكيانات (Message || BorrowRequest ....)
            return $this->morphTo();
         }
         public function getContentAttribute(){
            return app()->getLocale() == 'ha' && $this->content_ha ? $this->content_ha : $this->content;
         }
        }
