<?php

namespace App\Http\Livewire\Backend;

use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CategoryExport;
use App\Lib\Webspice;
use Livewire\Component;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use Carbon\Carbon;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CategoryComponent extends Component
{
    public $tableName = 'categories';
    public $flag = 0;

    public $searchTerm;
    public $status;
    public $pazeSize;
    public $orderBy;
    public $sortBy;
    /*field name*/
    public $ids;
    public $name;
    public $slug;
    public $image;
    public $new_image;
    public $old_image;
    public $is_popular;
    // public $slug;
    public $edit_name;
    // public $selected = '';
    public $export;
    use WithPagination;
    use WithFileUploads;
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
        $query = Category::select(
            '*'
        );

        if ($searchTerm != null) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', $searchTerm);
                $query->orWhere('slug', 'LIKE', $searchTerm);
            });
        }
        # By Option Group 
        // if ($this->name != null) {
        //     $query->where('name', $this->name);
        // }
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
            return Excel::download(new CategoryExport($query->get()), 'category_data_' . time() . '.xlsx');
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
        $categories = $query->paginate($paze_size);
        return view('livewire.backend.category.index', [
            'columns' => Schema::getColumnListing($this->tableName),
            'categories' => $categories
        ]);
    }
    public function store()
    {

        # Validate form data
        $this->validate([
            'image' => 'required',
            'is_popular' => 'required',
            'name' =>  [
                'required',
                Rule::unique('categories')->ignore($this->ids, 'id')->where(function ($query) {
                    return $query->where('name', $this->name);
                })
            ],
        ]);
        try {
            # Save form data
            $this->flag = 1;
            $category = new Category();
            $category->name = $this->name;
            $category->is_popular = $this->is_popular;
            $category->slug = Str::slug($this->name,'-');
            $category->created_by = Auth::user()->id;
            $imageName = '';
            if ($this->image != NULL) {
                #custom file name        
                $imageName = Carbon::now()->timestamp . "-product." . $this->image->extension();
            }
            # Upload Image
            // $destinationPath = 'frontend-assets/imgs/products';
            // if (File::exists(public_path($destinationPath . '/' . $existingRecord->website_favicon))) {
            //     File::delete(public_path($destinationPath . '/' . $existingRecord->website_favicon));
            // }            
            // $this->image->storeAs('products',$imageName);
            $category->image = $imageName;
            // if($this->image->move($destinationPath, $imageName)){
            if ($this->image->storeAs('categories', $imageName)) {
                $category->save();
            }

            if ($category->id) {
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
        $data = Category::find($id);
     
        $this->ids = $data->id;
        $this->name = $data->name;        
        $this->slug = $data->slug;
        $this->is_popular = $data->is_popular;
        $this->old_image = $data->image;
    }
    public function update()
    {
      
        # Validate form data
        $this->validate([
            'is_popular' => 'required',
            'name' =>  [
                'required',
                Rule::unique($this->tableName)->ignore($this->ids,'id')->where(function ($query) {
                    return $query->where('name', $this->name);
                })
            ],
        ]);
        
        try {
           
            $this->flag = 1;
            $data = Category::find($this->ids);
            $data->name = $this->name;
            $data->is_popular = $this->is_popular;
            $data->slug = Str::slug($this->name,'-');
            $data->updated_by = Auth::user()->id;
            if ($this->new_image) {
                $imageName = '';
                #custom file name        
                $imageName = Carbon::now()->timestamp . "-product." . $this->new_image->extension();
                $data->image = $imageName;
                $this->new_image->storeAs('categories', $imageName);
            }
            $data->save();
           
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
            $category = Category::find($id); 
            unlink('frontend-assets/imgs/categories/'.$category->image);
            $category->delete();
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
        $this->name = '';
        $this->slug = '';
        $this->image = '';
        $this->new_image = '';
        $this->old_image = '';
    }
}
