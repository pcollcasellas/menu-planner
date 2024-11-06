<?php

namespace App\Livewire;

use App\Models\MenuItem;
use App\Models\MenuTemplate;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ImportTemplate extends Component
{
    use LivewireAlert;

    public $weekStartDate;
    public $showModal;
    public $modalSearch;
    public $templates;

    public function mount($weekStartDate)
    {
        $this->templates = MenuTemplate::where('user_id', Auth::id())->get();
        $this->weekStartDate = Carbon::parse($weekStartDate);
    }

    public function render()
    {
        return view('livewire.import-template');
    }

    public function openImportTemplateModal()
    {
        $this->showModal = True;
    }

    public function onModalChange()
    {
        $search = '%' . $this->modalSearch . '%';
        $this->templates = MenuTemplate::where('user_id', Auth::id())
            ->where(function ($query) use ($search) {
                $query->orWhere('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('prep_time', 'like', '%' . $search . '%')
                    ->orWhere('cooking_time', 'like', '%' . $search . '%');
            })
            ->get();
    }

    public function addMenuTemplate($templateId)
    {
        try {
            DB::beginTransaction();

            $templateItems = MenuTemplate::find($templateId)->menu_template_items()->get();
            $templateItems->each(function ($item) {
                $itemData = [
                    'user_id' => Auth::id(),
                    'recipe_id' => $item->recipe_id,
                    'meal' => $item->meal,
                    'day' => $this->calculateActualDate($item->day),
                    'order' => $item->order
                ];

                MenuItem::create($itemData);
            });

            DB::commit();

            $this->showModal = False;
            $this->dispatch('refresh-menu-items');
            $this->alert('success', 'Template imported successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; // You can handle the exception as per your application's error handling strategy
        }
    }

    private function calculateActualDate($day)
    {
        return $this->weekStartDate->copy()->next(Carbon::parse($day)->dayOfWeek)->format('Y-m-d');
    }
}
