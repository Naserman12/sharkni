<?php

namespace App\Livewire\Pages\Categories;

use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;

class AddCategory extends Component
{
    public $name, $name_ha;
    protected $rules = [
        'name' => 'required|string|max:255|min:3|unique:categories,name',
        'name_ha' => 'required|string|max:255|min:3',
    ];
    public function  addCategory(){
        $this->validate();
        $slug = Str::slug($this->name);
        // slug فريد التاكد من ان
        $originalSlug = $slug;
        $count = 1;
        while (Category::where('slug', $slug)->exists()){
            $slug = $originalSlug. '-'.$count++;
        }
        Category::create([
            'name' => $this->name,
            'name_ha' => $this->name_ha,
            'slug' => $slug,
        ]);
        session()->flash('message', app()->getLocale() == 'ha' ? 'An Qara nau\'i cikin nasara! ' : 'Cstrgory added successfully!');
        $this->reset(['name', 'name_ha']);
    }
    public function render()
    {
        return view('livewire.pages.categories.add-category')->layout('layouts.app');
    }
}
