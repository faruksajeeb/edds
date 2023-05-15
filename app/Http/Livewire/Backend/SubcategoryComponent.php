<?php

namespace App\Http\Livewire\Backend;

use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SubcategoryExport;
use App\Lib\Webspice;
use Livewire\Component;
use Illuminate\Support\Facades\Schema;
use App\Models\SubCategory;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SubCategoryComponent extends Component
{
    public $tableName = 'sub_categories';
    public $flag = 0;

    public $searchTerm;
    public $status;
    public $pazeSize;
    public $orderBy;
    public $sortBy;
    /*field name*/
    public $ids;
    public $sub_category_name;
    // public $slug;
    public $category_id;
    public $search_category_id;
    public $sub_category_id;
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
        $query = Subcategory::select(
            '*'
        );

        if ($searchTerm != null) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('sub_category_name', 'LIKE', $searchTerm);
            });
        }
        # By Option Group 
        if ($this->search_category_id != null) {
            $query->where('category_id', $this->search_category_id);
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
            return Excel::download(new SubcategoryExport($query->get()), 'sub_category_data_' . time() . '.xlsx');
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
            $paze_size = 8;
        }
        $sub_categories = $query->paginate($paze_size);
        return view('livewire.backend.sub_category.index', [
            'columns' => Schema::getColumnListing($this->tableName),
            'categories' => DB::table('categories')->select('*')->where('status', 1)->get(),
            'sub_categories' => $sub_categories
        ]);
    }
    public function store()
    {

        # Validate form data
        $validator = $this->validate([
            'category_id' => 'required',
            'sub_category_name' =>  [
                'required',
                Rule::unique($this->tableName)->ignore($this->ids, 'id')->where(function ($query) {
                    return $query->where('category_id', $this->category_id)
                        ->where('sub_category_name', $this->sub_category_name);
                })
            ],
        ]);
        try {
            # Save form data
            $this->flag = 1;
            $sub_category = new Subcategory();
            $sub_category->category_id = $this->category_id;
            $sub_category->sub_category_name = $this->sub_category_name;
            $sub_category->created_by = Auth::user()->id;
            $sub_category->save();

            if ($sub_category->id) {
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
        $data = Subcategory::find($id);

        $this->ids = $data->id;
        $this->category_id = $data->category_id;
        $this->sub_category_name = $data->sub_category_name;
        // $this->slug = $data->slug;
    }
    public function update()
    {

        # Validate form data
        $this->validate([
            'category_id' => 'required',
            'sub_category_name' =>  [
                'required',
                Rule::unique($this->tableName)->ignore($this->ids, 'id')->where(function ($query) {
                    return $query->where('category_id', $this->category_id)
                        ->where('sub_category_name', $this->sub_category_name);
                })
            ],
        ]);

        try {

            $this->flag = 1;
            $sub_category = Subcategory::find($this->ids);

            $sub_category->category_id = $this->category_id;
            $sub_category->sub_category_name = $this->sub_category_name;
            $sub_category->updated_by = Auth::user()->id;

            $sub_category->save();
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
            Subcategory::where('id', $id)->delete();
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
        $this->category_id = '';
        $this->sub_category_name = '';
    }
}
