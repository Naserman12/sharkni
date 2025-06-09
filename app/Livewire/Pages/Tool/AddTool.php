<?php

namespace App\Livewire\Pages\Tool;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Tool;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AddTool extends Component
{
    use WithFileUploads;

    public $category_id, $name, $description, $location, $images = [], $rental_price,
           $is_free = false, $deposit_amount,
            $status = 'available', $condition = 'used';
    public $categories;

    public function mount(){
        $user = Auth::user();
                app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
                session(['locale' => $user->language]); // تخزين اللغة في الجلسة
        $this->categories = Category::all();
    }
    protected $rules =[
        'category_id' => ['required','exists:categories,id'],
        'name' => ['required','string','max:255'],
        'description' => ['nullable','string'],
        'is_free' => ['boolean'],
        'rental_price' => ['nullable','numeric','min:0','required_if:is_free,0'], //'rental_price' => ['required_if:is_free,false', 'numeric', 'min:0'],
        'deposit_amount' => ['nullable','numeric','min:0'],
        'status' => ['required', 'in:available,borrowed,unavailable'],
        'condition' => ['required', 'in:new,used,needs_repair'],
        'images' => [ 'nullable','array', 'min:0'],
        'images.*' => [ 'image','max:2048'],
        'location' => ['required', 'string','max:255']
    ];
    public function addTool(){
        try {
            
            $this->validate();
            // اذا كان مجاني السعر غير مطلوب
            if ($this->is_free === false && is_null($this->rental_price)) {
                $this->addError('rental_price', app()->getLocale() == 'ha' ? 'Farashin kowace rana yana da mahimmanci idan ba kyauta ba ne' : 'Price per day is required if the tool is not free.');
                return;
            }
            // رفع  الصور اذت وجدت
            $imagePaths = [];
            if ($this->images) {
                foreach($this->images as $image){
                    $imagePaths[] = $image->store('tools', 'public');
                }
            }
            if ($this->is_free === true) {
                $this->rental_price = 0;
            }
            // إضافة الاداة
            Tool::create([
                'user_id' => Auth::id(),
                'category_id'=> $this->category_id,
                'name' => $this->name,
                'description' => $this->description,
                'rental_price' => $this->rental_price,
                'is_free' => $this->is_free,
                'deposit_amount' => $this->deposit_amount,
                'status' => $this->status,
                'condition' => $this->condition,
                'image_paths' => $imagePaths,
                'location'=> $this->location,
              
            ]);
            session()->flash('message', app()->getLocale() == 'ha' ? 'An qara kayan aiki cikin nasara! ' : 'Tool added successfully!');
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            $this->addError('form', app()->getLocale() == 'ha' ? 'An samu matsala yayin qara kayan aiki '.$e->getMessage(): 'An error occurred while adding the tool'.$e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.pages.tool.add-tool')->layout('layouts.app');
    }
}
