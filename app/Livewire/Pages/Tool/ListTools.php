<?php

namespace App\Livewire\Pages\Tool;

use App\Models\Category;
use App\Models\Tool;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ListTools extends Component
{
    public $category_id, $location, $status = 'available', $price_max = '';
    public $categories;
     
    public function mount(){
       Log::info('ListTools component mounted');
        $this->categories = Category::all();
               $user = Auth::user();
                app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
                session(['locale' => $user->language]); // تخزين اللغة في الجلسة
        Log::info('Categories loaded' . $this->categories->count());
    }
    public function updated($field){
        Log::info('Filter updated',[
            'freld' => $field,
            'category_id' => $this->category_id,
            'location' => $this->location,
            'status' => $this->status,
        ]);
        // $this->resetPage();
    }
    public function updatedCategoryId($value)
        {
            $this->category_id = (int) $value;
        }
    public function render()
    {
        $query = Tool::query() // عرض الأدوات الماتحة فقط بشكل افتراضي
                        
                         ->with(['user', 'category']);
        // التنقية بناء على الفئة
        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }
        // التنقية بناء على تاالموفع
        if ($this->location) {
            $query->whereRaw('LOWER(location) LIKE ?', ['%'. strtolower($this->location) .'%'] );
        }
        // التنقية بناء على الحالة
        if ($this->status) {
            $query->where('status', $this->status);
        }else{
            $query->where('status', 'available');

        }
        
        if ($this->price_max) {
            $query->where('is_free', false)
                  ->where('price', '<=', $this->price_max);
        }
        $tools = $query->get();
        return view('livewire.pages.tool.list-tools',[
            'tools' => $tools ,
        ])->layout('layouts.app');
    }
}
