<?php

namespace App\Livewire\Pages\Tool;

use App\Models\Category;
use App\Models\Tool;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class ListTools extends Component
{
    use WithPagination;
    public  $location, $status, $price_max = '',
           $category_slug = '', $selected_category = null;
    public $perPage = 10; // على الشاشات الكبيرة افتراضي
    public $categories;
     
    public function mount($slug = null){
       
        $this->categories = Category::all();
               $user = Auth::user();
                app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
                session(['locale' => $user->language]); // تخزين اللغة في الجلسة
                
        if ($slug) {
            $this->category_slug = $slug;
            $this->selected_category = Category::where('slug', $slug)->firstOrFail();
        }
        // ضبط عدد  العناصر على حسب حجم الشاشة
        $this->perPage = request()->header('User-Agent') && preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'))? 5 : 10;
        Log::info('Categories loaded' . $this->categories->count());
    }
    public function resetCategoryFilter(){
        $this->category_slug = '';
        $this->selected_category = null;
        return redirect()->route('tools.index');
    }
    public function updated($field){
        Log::info('Filter updated',[
            'freld' => $field,
            // 'category_id' => $this->category_id,
            'location' => $this->location,
            'status' => $this->status,
        ]);
        // $this->resetPage();
    }
    // public function updatedCategoryId($value)
    //     {
    //         $this->category_id = (int) $value;
    //     }
    public function render()
    {
        $query = Tool::query() // عرض الأدوات الماتحة فقط بشكل افتراضي             
                         ->with(['user', 'category']);
        // التنقية بناء على الفئة
        if ($this->category_slug && $this->selected_category) {
            $query->where('category_id', $this->selected_category->id);
        }
        // التنقية بناء على تاالموفع
        if ($this->location) {
            $query->whereRaw('LOWER(location) LIKE ?', ['%'. strtolower($this->location) .'%'] );
        }
        // التنقية بناء على الحالة
        if ($this->status) {
            $query->where('status', $this->status);
        }else{
            $query->where('status',  'available');

        }
        if ($this->price_max) {
            $query->where('is_free', false)
                  ->where('rental_price', '<=', $this->price_max);
        }
        $tools = $query->paginate($this->perPage);
        return view('livewire.pages.tool.list-tools',[
            'tools' => $tools ,
        ])->layout('layouts.app')->with(['paginationView' => 'vendor.pagination.tailwind']);
    }
}
