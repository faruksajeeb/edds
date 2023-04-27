@push('styles')
    <style>

    </style>
@endpush
<!-- Modal -->
<div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form wire:submit.prevent="store">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus"></i> Create Option
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"  style="overflow:hidden;">

                    @if (session()->has('message'))
                        <div class="alert alert-danger">{{ session('message') }}</div>
                    @endif
                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}
                    <div class="form-group row">
                        <label for="option-group" class="form-label">Option Group:</label>
                        <div class="col-12">
                  
                                <select name="option_group" id="option_group" wire:model='option_group'
                                    class="form-select select2">
                                    <option value="">--Option Group--</option>
                                    @foreach ($option_groups as $val)
                                        <option value="{{ $val->option_group_name }}">{{ $val->option_group_name }}
                                        </option>
                                    @endforeach
                                </select>
                           
                            @error('option_group')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="option-group" class="form-label">Option Value:</label>
                        <div class="col-12">
                            <input type="text" name="option_value" id="option_value" wire:model="option_value"
                                class="form-control form-control-lg option_group_name" placeholder="Enter Option Value">
                            @error('option_value')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="option-group" class="form-label">Option Value2:</label>
                        <div class="col-12">
                            <input type="text" name="option_value2" id="option_value2" wire:model="option_value2"
                                class="form-control form-control-lg" placeholder="Enter Option Value2">
                            @error('option_value2')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="option-group3" class="form-label">Option Value3:</label>
                        <div class="col-12">
                            <input type="text" name="option_value3" id="option_value3" wire:model="option_value3"
                                class="form-control form-control-lg" placeholder="Enter Option Value3">
                            @error('option_value3')
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
                            class="fa fa-save"></i> Save New</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
         $(document).ready(function() {
          //  $("#option_group").select2({ dropdownParent: "#addModal" });
          $('#addModal').on('shown.bs.modal', function (e) {
            $('#option_group').select2({
            placeholder: 'Select an option group',
            dropdownParent:$('#option_group').parent(),
            });
            $('#option_group').on('change', function(e) {
                var data = $(this).val();
                Livewire.emit('listenerReferenceHere',data);               
                @this.set('option_group', data);
                // $('#option_group').select2();
            });
        });
});
</script>
@endpush
