<?php

namespace App\Livewire\Pages\Categories;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class EditCategory extends Component
{
    public $categoryId, $category,$name,$name_ha;
    protected $rules =[
        'name' => 'required|string|max:255',
        'name_ha' => 'required|string|max:255'
    ];
    public function mount($id)  {
        $this->categoryId =  $id;
        $this->category = Category::findOrFail($id);
        $this->name = $this->category->name;
        $this->name_ha = $this->category->name_ha;
    }
    public function updateCategory()  {
        $this->validate();

        $this->category->update([
            'name' => $this->name,
            'name_ha' => $this->name_ha,
            'slug' => Str::slug($this->name),
        ]);
        session()->flash('message', __('messages.category_updated'));
    }
    public function render()
    {
        return view('livewire.pages.categories.edit-category')->layout('layouts.app');
    }
}
