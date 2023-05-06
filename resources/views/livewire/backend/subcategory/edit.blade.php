<!-- Modal -->
<div wire:ignore.self class="modal fade" id="editModal" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form wire:submit.prevent="update" method="POST"  class="needs-validation" novalidate>
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> Edit Subcategory
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    @if (session()->has('message'))
                        <div class="alert alert-danger">{{ session('message') }}</div>
                    @endif
            
                    <div class="form-group row">
                        <label for="" class="form-label">Category:</label>
                        <div class="col-12">                  
                                <select name="category_id" wire:model='category_id'
                                    class="form-select select2">
                                    <option value="">--Category Name--</option>
                                    @foreach ($categories as $val)
                                        <option value="{{ $val->id }}">{{ $val->name }}
                                        </option>
                                    @endforeach
                                </select>
                           
                            @error('category_id')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="option-group" class="form-label">Subcategory Name:</label>
                        <div class="col-12">
                            <input type="text" name="subcategory_name" id="subcategory_name" wire:model="subcategory_name"
                                class="form-control form-control-lg name" placeholder="Enter Subcategory Name">
                            @error('subcategory_name')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        wire:click="resetInputFields()"><i class="fa fa-remove"></i> Close</button>


                    <button type="button" class="btn btn-warning" wire:click="resetInputFields()"><i
                            class="fa fa-refresh"></i> Reset</button>
                    <button type="submit" class="btn btn-primary" {{ $flag == 1 ? 'disabled' : '' }}><i
                            class="fa fa-save"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
$(document).ready(function() {
          $('#editModal').on('shown.bs.modal', function (e) {
            
        });
});
    </script>
@endpush
