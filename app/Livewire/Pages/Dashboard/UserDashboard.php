<?php

namespace App\Livewire\Pages\Dashboard;

use App\Models\Tool;
use Livewire\Component;

class UserDashboard extends Component
{
    public $search = ''; 
    protected $queryString = ['search'];

    public function mount(){

    }

    public function render()
    {
        $featuredTools = Tool::where('status', 'available')
        ->where(function($query){
            $query->where('location', 'like', '%Kano%')
                  ->orwhere('location', 'like', '%Dala%')
                  ->orwhere('location', 'like', '%Nasrawa%')
                  ->orwhere('location', 'like', '% %')
                  ->orwhere('location', 'like', '%Fagge%');
        })->when($this->search, function($query){
            $query->where('location', 'like', '%'.$this->search.'%')
                ->orWhere('name', 'like', '%'.$this->search.'%');
        })->take(10)->get();
        return view('livewire.pages.dashboard.user-dashboard', [
            'featuredTools' => $featuredTools,
        ])->layout('layouts.app');
    }
}
