<?php

namespace App\Livewire\Pages\Damage;

use App\Models\DamageReport;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ReportDamage extends Component
{
    use WithFileUploads;

    public $rental_id, $description, $images = [], $rentals;

    protected $rules = [
        'rental_id' => 'required:exists:rentals,id',
        'description' => 'nullable|string|min:10',
        'image.*' => 'nullable|image|max:10240',
    ];
    public function mount(){
        $this->rentals = Rental::where('lender_id', Auth::id())->orWhere('borrower_id', Auth::id())->get();
            $user = Auth::user();
            app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
            session(['locale' => $user->language]); // تخزين اللغة في الجلسة
         
    }
    public function reportDamage(){
        $this->validate();

        $imagePaths = [];
        if ($this->images) {
            foreach($this->images as $image){
                $imagePaths[] = $image->store('damage', 'public');
            }
        }
        DamageReport::create([
            'rental_id' => $this->rental_id,
            'description' => $this->description,
            'image_paths' => $imagePaths,
            'status' => 'pending',
        ]);
        session()->flash('message', app()->getLocale() == 'ha' ? 'An qaddamar da rahoton lalacewa cikin nasara!' : 'Damage report submitted successfully!');
        $this->reset(['rental_id', 'description', 'images']);
    }
    public function render()
    {
        return view('livewire.pages.damage.report-damage')->layout('layouts.app');
    }
}
