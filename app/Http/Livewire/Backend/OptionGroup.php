<?php

namespace App\Http\Livewire\Backend;

use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OptionGroupExport;
use App\Lib\Webspice;
use Livewire\Component;
use Illuminate\Support\Facades\Schema;
use App\Models\Option_group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class OptionGroup extends Component
{
    public $table = 'option_groups';
    public $flag = 0;
    public $searchTerm;
    public $pazeSize;
    public $orderBy;
    public $sortBy;
    /*field name*/
    public $ids;
    public $option_group_name;

    public $export;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function updatedSearchTerm()
    {
        $this->resetPage();
    }
    public function updatedsearchMonth()
    {
        $this->resetPage();
    }
    public function updatedsearchYear()
    {
        $this->resetPage();
    }
    public function updatedorderBy()
    {
        $this->resetPage();
    }
    public function updatedsortBy()
    {
        $this->resetPage();
    }
    public function updatedpazeSize()
    {
        $this->resetPage();
    }
    public function render($export = null)
    {

        $searchTerm = '%' . $this->searchTerm . '%';
        $query = Option_group::select(
            'option_groups.*'
        );

        if ($searchTerm != null) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('option_groups.option_group_name', 'LIKE', $searchTerm);
            });
        }
        // Sort By
        if (($this->orderBy != null) && ($this->sortBy != null)) {
            $query->orderBy("option_groups." . $this->orderBy, $this->sortBy);
        } elseif (($this->orderBy != null) && ($this->sortBy == null)) {
            $query->orderBy("option_groups." . $this->orderBy, "DESC");
        } elseif (($this->orderBy == null) && ($this->sortBy != null)) {
            $query->orderBy("option_groups.id", $this->sortBy);
        } else {
            $query->orderBy("option_groups.id", "DESC");
        }

        if ($export == 'excelExport') {
            return Excel::download(new OptionGroupExport($query->get()), 'option_group_data_' . time() . '.xlsx');
        }
        // if($export=='pdfExport'){
        //     # Generate PDF  
        //     $data['option_groups'] = $query->get();          
        //     $pdf = PDF::loadView('livewire.option-group.table',$data);
        //     $pdf->set_paper('letter', 'landscape');
        //     return $pdf->download('option-groups-' . time() . '.pdf');
        // }

        if ($this->pazeSize != null) {
            $paze_size = $this->pazeSize;
        } else {
            $paze_size = 7;
        }
        $option_groups = $query->paginate($paze_size);
        return view('livewire.backend.option-group.index', [
            'columns' => Schema::getColumnListing('option_groups'),
            'option_groups' => $option_groups
        ]);
    }
    public function store()
    {

        # Validate form data
        $validator = $this->validate([
            'option_group_name' => 'required|unique:option_groups,option_group_name|min:3|max:100'
        ]);
        try {
            # Save form data
            $this->flag = 1;
            $optionGroup = new Option_group();
            $optionGroup->option_group_name = $this->option_group_name;
            $optionGroup->created_by = Auth::user()->id;
            $optionGroup->save();

            if ($optionGroup->id) {
                # Reset form
                $this->resetInputFields();
                # Write Log
                Webspice::log($this->table, $optionGroup->id, 'INSERTED');
                # Update Cache
                //  $cache = Redis::get($request->table);
                // if (!isset($cache)) {
                // 	$cache = DB::table($request->table)->get();
                // 	Redis::set($request->table, json_encode($cache));
                // 	$cache = Redis::get($request->table);
                // }
                // $cache = Cache::get($this->table);

                // if (!isset($cache)) {
                //     $cache = DB::table($this->table)->get();
                //     Cache::set($this->table, json_encode($cache));
                //     $cache = Cache::get($this->table);
                // }
                Cache::forget($this->table);
                # Return Message
                $this->emit('added', 'inserted');
            }
        } catch (\Exception $e) {
            $this->emit('error', $e->getMessage());
        }

        $this->flag = 0;
    }
    public function edit($id)
    {
        $this->resetInputFields();
        $id = Crypt::decryptString($id);
        $data = Option_group::find($id);
        $this->ids = $data->id;
        $this->option_group_name = $data->option_group_name;
    }
    public function update()
    {
        # Validate form data
        $validator = $this->validate([
            'option_group_name' => 'min:3|max:100|required|unique:option_groups,option_group_name,' . $this->ids,
        ]);
        try {
            $this->flag = 1;
            $data = Option_group::find($this->ids);
            $data->update([
                'option_group_name' => $this->option_group_name,
                'updated_by' => Auth::user()->id
            ]);
            # Write Log
            Webspice::log($this->table, $this->ids, 'UPDATE');
            # reset form
            $this->resetInputFields();
            # Cache Update
            Cache::forget($this->table);
            $this->emit('success', 'updated');
        } catch (\Exception $e) {
            $this->emit('error', $e->getMessage());
        }

        $this->flag = 0;
    }
    public function destroy($id)
    {
        try {
            $id = Crypt::decryptString($id);
            Option_group::where('id', $id)->delete();

            # Write Log
            Webspice::log($this->table, $id, 'DELETE');
            # Cache Update
            Cache::forget($this->table);
            # Success message
            $this->emit('success', 'deleted');
        } catch (\Exception $e) {
            $this->emit('error', $e->getMessage());
        }
    }
    public function resetInputFields()
    {
        $this->resetErrorBag();
        $this->ids = '';
        $this->option_group_name = '';
    }
}
