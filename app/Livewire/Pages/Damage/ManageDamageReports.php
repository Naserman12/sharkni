<?php

namespace App\Livewire\Pages\Damage;

use App\Models\DamageReport;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ManageDamageReports extends Component
{
    public $reports, $editingReportId = null, $status, $resolution_amount;
    protected $rules =[
        'status' => 'required|in:pending,accepted,rejected',
        'resolution_amount' => 'nulllable:numeric|min:0|required_if:status,accepted',
    ]; 
    public function mount(){
        $user = Auth::user();
        app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
        session(['locale' => $user->language]); // تخزين اللغة في الجلسة
        $this->loadReports();
    }
    public function loadReports(){
        $query = DamageReport::with('rental')->orderBy('created_at', 'desc');
        if (!Auth::user()->admin) {
            $rental = Rental::where('lender_id', Auth::id())->orWhere('borrower_id', Auth::id())->pluck('id');
            $query->whereIn('rental_id', $rental);
        }
        $this->reports = $query->get();
    }
    public function editRepot($reportId){
        $report = DamageReport::findOrFail($reportId);
        $this->editingReportId = $reportId;
        $this->status = $report->status;
        $this->resolution_amount = $report->resolution_amount;
    }
    public function updateReport(){
        $this->validate();

        $report = DamageReport::findOrFail($this->editingReportId);
        $report->update([
            'status' => $this->status,
            'resolution' => $this->status === 'accepted' ? $this->resolution_amount : null,
        ]);
        session()->flash('message', app()->getLocale() == 'ha' ? 'An sabunta rahoton lalacewa cikin nasara!' : 'Damage report updated successfully!');

        $this->reset(['editingReportId', 'status', 'resolution_amount']);
        $this->loadReports();
    }
    public function cancelEdit(){
        $this->reset(['editingReportId', 'status', 'resolution_amount']);
    }
    public function render()
    {
        return view('livewire.pages.damage.manage-damage-reports')->layout('layouts.app');
    }
}
