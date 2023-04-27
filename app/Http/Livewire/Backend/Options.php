<?php

namespace App\Http\Livewire\Backend;

use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OptionExport;
use App\Lib\Webspice;
use Livewire\Component;
use Illuminate\Support\Facades\Schema;
use App\Models\Option;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Cache;

class Options extends Component
{
    public $tableName = 'options';
    public $flag = 0;

    public $searchTerm;
    public $status;
    public $pazeSize;
    public $orderBy;
    public $sortBy;
    /*field name*/
    public $ids;
    public $edit_option_group;
    public $option_group;
    public $option_group_name;
    public $option_value;
    public $option_value2;
    public $option_value3;
    // public $selected = '';
    public $export;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function updatedSearchTerm()
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
        $query = Option::select(
            '*'
        );

        if ($searchTerm != null) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('option_group_name', 'LIKE', $searchTerm);
                $query->orWhere('option_value', 'LIKE', $searchTerm);
                $query->orWhere('option_value2', 'LIKE', $searchTerm);
                $query->orWhere('option_value3', 'LIKE', $searchTerm);
            });
        }
        # By Option Group 
        if ($this->option_group_name != null) {
            $query->where('option_group_name', $this->option_group_name);
        }
        # By status
        if ($this->status != null) {
            $query->where('status', $this->status);
        }
        # Sort By
        if (($this->orderBy != null) && ($this->sortBy != null)) {
            $query->orderBy($this->orderBy, $this->sortBy);
        } elseif (($this->orderBy != null) && ($this->sortBy == null)) {
            $query->orderBy($this->orderBy, "DESC");
        } elseif (($this->orderBy == null) && ($this->sortBy != null)) {
            $query->orderBy("id", $this->sortBy);
        } else {
            $query->orderBy("id", "DESC");
        }

        if ($export == 'excelExport') {
            return Excel::download(new OptionExport($query->get()), 'option_data_' . time() . '.xlsx');
        }
        // if($export=='pdfExport'){
        //     # Generate PDF  
        //     $data['option'] = $query->get();          
        //     $pdf = PDF::loadView('livewire.option-group.table',$data);
        //     $pdf->set_paper('letter', 'landscape');
        //     return $pdf->download('option-groups-' . time() . '.pdf');
        // }

        if ($this->pazeSize != null) {
            $paze_size = $this->pazeSize;
        } else {
            $paze_size = 7;
        }
        $options = $query->paginate($paze_size);
        return view('livewire.backend.option.index', [
            'columns' => Schema::getColumnListing($this->tableName),
            'option_groups' => DB::table('option_groups')->select('*')->where('status', 1)->get(),
            'options' => $options
        ]);
    }
    public function store()
    {

        # Validate form data
        $validator = $this->validate([
            'option_group' => 'required',
            'option_value' =>  [
                'required',
                Rule::unique('options')->ignore($this->ids, 'id')->where(function ($query) {
                    return $query->where('option_group_name', $this->option_group)
                        ->where('option_value', $this->option_value);
                })
            ],
        ]);
        try {
            # Save form data
            $this->flag = 1;
            $option = new Option();
            $option->option_group_name = $this->option_group;
            $option->option_value = $this->option_value;
            $option->option_value2 = $this->option_value2;
            $option->option_value3 = $this->option_value3;
            $option->created_by = Auth::user()->id;
            $option->save();

            if ($option->id) {
                # Reset form
                $this->resetInputFields();
                # Write Log
                Webspice::log($this->tableName, $this->ids, 'INSERT');
                # Cache Update
                Cache::forget($this->tableName);
                $this->emit('success', 'inserted');
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
        $data = Option::find($id);
        $this->ids = $data->id;
        $this->option_group = $data->option_group_name;
        $this->option_value = $data->option_value;
        $this->option_value2 = $data->option_value2;
        $this->option_value3 = $data->option_value3;
    }
    public function update()
    {
        # Validate form data
        $validator = $this->validate([
            'option_group' => 'required',
            'option_value' =>  [
                'required',
                Rule::unique($this->tableName)->ignore($this->ids,'id')->where(function ($query) {
                    return $query->where('option_group_name', $this->option_group)
                        ->where('option_value', $this->option_value);
                })
            ],
        ]);
        try {
            $this->flag = 1;
            $data = Option::find($this->ids);
            $data->update([
                'option_group_name' => $this->option_group,
                'option_value' => $this->option_value,
                'option_value2' => $this->option_value2,
                'option_value3' => $this->option_value3,
                'updated_by' => Auth::user()->id
            ]);
            # Write Log
            Webspice::log($this->tableName, $this->ids, 'UPDATE');
            # Cache Update
            Cache::forget($this->tableName);
            # reset form
            $this->resetInputFields();
            # Return Message
            $this->emit('success', 'updated');
        } catch (\Exception $e) {
            # Return Message
            $this->emit('error', $e->getMessage());
        }

        $this->flag = 0;
    }
    public function destroy($id)
    {
        try {
            $id = Crypt::decryptString($id);
            Option::where('id', $id)->delete();
            # Write Log
            Webspice::log($this->tableName, $id, 'DELETE');
            # Cache Update
            Cache::forget($this->tableName);
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
        $this->option_group = '';
        $this->option_value = '';
        $this->option_value2 = '';
        $this->option_value3 = '';
    }
}
