<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Tool;
use App\Models\BorrowRequest;
use App\Models\Rating;
use App\Models\Notification;
use App\Models\Transaction;
use App\Models\Message;
use App\Notifications\CustomVerifyEmail;
use Dom\Notation;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Mail\Message as MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification as NotificationsNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email','password', 'phone','reputation_points',
        'language', 'address', 'national_id', 'is_verified'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'email_verified_at' => 'datetime',
        'is_verified' => 'boolean',
        'password',
        'remember_token',
    ];
    public function sendEmailVerificationNotification(){
        $this->notify(new CustomVerifyEmail);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function tools(){
        return $this->hasMany(Tool::class);
    }
    public function borrowRequestsAsBorrower(){
        return $this->hasMany(BorrowRequest::class, 'borrower_id');
    }
    public function borrowRequestsAsLender(){
        return $this->hasMany(BorrowRequest::class, 'lender_id');
        
    }
    public function ratingsGiven(){
        return $this->hasMany(Rating::class, 'reter_id');
        
    }
    public function ratingsReceived(){
        return $this->hasMany(Rating::class, 'rated_user_id');

    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function transactions(){
        return $this->hasMany(Transaction::class);
        
    }
    public function sentMessages(){
        return $this->hasMany(Message::class, 'sender_id');
    }
    public function receivedMessage(){
        return $this->hasMany(Message::class, 'receiver_id');
    }
    public function updateReputation($rating){
        return $this->reputation_points += $rating * 2;
        $this->save();
    }
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_verified' => 'boolean',
            'password' => 'hashed',
        ];
    }
}
