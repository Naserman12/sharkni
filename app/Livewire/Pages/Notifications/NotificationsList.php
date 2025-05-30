<?php

namespace App\Livewire\Pages\Notifications;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationsList extends Component
{
    
     public $notificationId;
     public $selectedNotification;
    public $notificationDetails = [];
    public $showDropdown = false;
    public $notifications = [], $notification;
    public $unreadCount;
   
    public function mount(){
        // $this->notificationId = $notificationId;
        $this->unreadCount = Auth::user()->unreadNotifications->count();
        $this->loadNotification();
    }
    public function loadNotification(){
    
    }
    public function showNotificationDetails($id)
{
    $this->selectedNotification = Auth::user()->notifications->find($id);

    if ($this->selectedNotification) {
        $this->notificationDetails = $this->selectedNotification->data ?? [];
        $this->selectedNotification->markAsRead(); // اختياري
    }
}

    public function markAsRead($id){
        $this->notification = Auth::user()
        ->notifications->findOrFail($id);
    if ($this->notification) {
        $this->notification->markAsRead();
    }
    }
    public function markAllAsRead(){
        Auth::user()
        ->unreadNotifications->markAsRead();
        $this->showDropdown = false;
        $this->loadNotification();
    }
    public function getNotifications(){
        return Auth::user()
                ->notifications
                ->latest()->paginate(10);
    }
    public function toggleDropdown(){
        $this->showDropdown = !$this->showDropdown;
    }
    public function render()
    {
        return view('livewire.pages.notifications.notifications-list', [
        'notifications' => Auth::user()->notifications()->latest()->take(10)->get(),
        'notificationDetails' => $this->notificationDetails,
    ]);
    }
}
