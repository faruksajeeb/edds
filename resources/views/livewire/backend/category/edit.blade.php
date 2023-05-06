<!-- Modal -->
<div wire:ignore.self class="modal fade" id="editModal" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form wire:submit.prevent="update" class="needs-validation" method="POST" class="needs-validation" novalidate>
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> Edit Category
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    @if (session()->has('message'))
                        <div class="alert alert-danger">{{ session('message') }}</div>
                    @endif
            
                    
                    <div class="form-group row">
                        <label for="option-group" class="form-label">Category Name:</label>
                        <div class="col-12">
                            <input type="text" name="name" wire:model="name"
                                class="form-control form-control-lg option_group_name" placeholder="Enter Category Name">
                            @error('name')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row my-1">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Category Image <span class="text-danger"></span></label>
                                <input name="new_image" id="new_image" wire:model="new_image"
                                    class="form-control new_image @error('new_image') is-invalid @enderror" type="file"
                                    >
                                @if ($new_image)
                                    <img src="{{ $new_image->temporaryUrl() }}" width="100" alt="product image" />
                                @else 
                                    <img src="{{asset('frontend-assets/imgs/categories')}}/{{$old_image}}" width="80" height="80" alt="{{$name}}">
                                @endif
                                {{-- <img id="product_image_preview" src="uploads/{{ $image ? $image : old('image') }}"
                                    class="img-fluid" width="16" height="16" alt=""> --}}
                                @error('new_image')
                                    <div class="invalid-feedback error_msg">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row my-1">
                        <div class="col-md-12">
                            <label for="">Popular: <span class="text-danger">*</span></label>
                            <select name="is_popular" wire:model='is_popular' placeholder='Select a is_popular'
                                class="form-select   is_popular  @error('is_popular') is-invalid @enderror" required>
                                <option value=""> Select Popular </option>
                                <option value="1"> Yes</option>
                                <option value="0"> No</option>
                            </select>
                            @error('is_popular')
                            <div class="invalid-feedback error_msg">{{ $message }}</div>
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
