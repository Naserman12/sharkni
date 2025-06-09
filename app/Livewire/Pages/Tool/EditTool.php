<?php

namespace App\Livewire\Pages\Tool;

use App\Models\Category;
use App\Models\Tool;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditTool extends Component
{
    public  $tool,
            $name, 
            $description, 
            $rental_price, 
            $is_free, 
            $deposit_amount, 
            $location, 
            $category_id, 
            $image_paths =[],
            $categories;
            protected $rules= [
                'name'          =>'required|string|max:255',
                'description'   =>'nullable|string',
                'rental_price'  =>'nullable|numeric|min:0|required_if:is_free,0',
                'is_free'       =>'boolean',
                'deposit_amount'=>'nullable|numeric|min:0', 
                'location'      =>'required|string|max:255',
                'category_id'   =>'required|exists:categories,id',
                'image_paths'    =>'array'
            ];
    public function mount($id)  {
        $this->tool = Tool::findOrFail($id);
        if ($this->tool->user_id !== Auth::id()) {
            abort(403, app()->getLocale() == 'ha' ? 'Ba za ka iya sake gyara wannan kayan aiki ba!':'You are not authorized to edit this tool!');
        }
        $this->name = $this->tool->name;
        $this->description = $this->tool->description;
        $this->rental_price = $this->tool->rental_price;
        $this->is_free = $this->tool->is_free;
        $this->deposit_amount = $this->tool->deposit_amount;
        $this->location = $this->tool->location;
        $this->category_id = $this->tool->category_id;
        $this->image_paths= $this->tool->image_paths ?? [];
        $this->categories = Category::all();
    }
    public function updateTool()  {
        $this->validate();

        $this->tool->update([
               'name'           => $this->name,
                'description'   => $this->description,
                'rental_price'  =>$this->rental_price,
                'is_free'       =>$this->is_free,
                'deposit_amount'=>$this->deposit_amount,
                'location'      =>$this->location,
                'category_id'   =>$this->category_id,
                'image_paths'   =>$this->image_paths,
        ]);
        session()->flash('message', app()->getLocale() == 'ha' ? 'An gyara kayan aiki cikin nasara!' : 'Tool updated successfully!');
    }
    public function deleteTool()  {
        if ($this->tool->user_id !== Auth::id()) {
            abort(403, app()->getLocale() == 'ha' ? 'Ba za ka iya share wannan kayan aiki ba!':'You are not authorized to delete this tool!');
            $this->tool->delete();
            session('message', app()->getLocale() == 'ha' ? 'An share kayan aiki cikin nasara!' : 'Tool Deleted successfully!');
            return redirect()->route('tools.index');
            
        }
    }
    public function render()
    {
        return view('livewire.pages.tool.edit-tool')->layout('layouts.app');
    }
}
