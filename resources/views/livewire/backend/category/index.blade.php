<x-slot name="title">
    Categories
</x-slot>

<div>
    <section>

        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header bg-white my-0 pt-2 pb-0">
                        <div class="row ">
                            <div class="col-md-8">
                                <h4 class="card-title py-1"><i class="fa fa-list"></i> Categories</h4>
                                {{-- <nav aria-label="breadcrumb" class="float-start m-0 p-0">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                        <li class="breadcrumb-item " aria-current="page">Categories</li>
                                    </ol>
                                </nav> --}}
                            </div>
                            <div class="col-md-4 col-sm-12 text-end">
                                {{-- @if ($loggedUser && $loggedUser->can('option_group.export')) --}}
                                <a class="btn btn-sm btn-success float-end" wire:click.prevent="render('excelExport')"><i
                                        class="fa-solid fa-download"></i> Export</a>
                                {{-- <a class="btn btn-sm btn-danger float-end mx-1" wire:click.prevent="render('pdfExport')"><i
                                        class="fa-solid fa-download"></i> PDF</a> --}}
                                {{-- @endif --}}
                                {{-- @if ($loggedUser && $loggedUser->can('option_group.create')) --}}
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-outline-primary float-end me-1"
                                    data-bs-toggle="modal" data-bs-target="#addModal"
                                    wire:click="resetInputFields()">
                                    <i class="fa-solid fa-plus"></i> Create New
                                </button>
                                {{-- <a href="{{ route('users.create') }}" class="btn btn-xs btn-outline-primary float-end"
                                    name="create_new" type="button">
                                    <i class="fa-solid fa-plus"></i> Create New
                                </a> --}}
                                {{-- @endif --}}
                            </div>

                        </div>
                    </div>
                    <div class="card-body py-1">
                        <div class="row my-1">
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input class="form-control border-end-0 border rounded-pill" type="text"
                                        placeholder="Search..." wire:model="searchTerm">
                                </div>
                                {{-- <span>{{ $searchTerm }}</span> --}}
                            </div>
                            <div class="col-md-2">
                                <select name="" id="" wire:model='status' class="form-control">
                                    <option value="">--Status--</option>
                                    <option value="1">Active</option>
                                    <option value="-1">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="" id="" wire:model='orderBy' class="form-control">
                                    <option value="">--Order By--</option>
                                    @foreach ($columns as $col)
                                        <option value="{{ $col }}">{{ $col }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="" id="" wire:model='sortBy' class="form-control">
                                    <option value="">--Sort By--</option>
                                    <option value="DESC">Decending</option>
                                    <option value="ASC">Ascending</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">
                                Per Page
                                <select name="" id="" class="py-0" wire:model='pazeSize'>
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="100">100</option>
                                    <option value="500">500</option>
                                </select>
                                Current Page {{ $categories->currentPage() }}
                            </div>
                        </div>

                        <table class="table table-striped table-brodered table-sm">
                            <thead>
                                <tr>
                                    <th>Sl.</th>
                                    <th>Image</th>
                                    <th>Category Name</th>
                                    <th>Slug</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @endforelse ($categories as $key => $val)
                                    <tr>
                                        <td>{{ $key + $categories->firstItem() }}</td>
                                        <td><img src="{{asset('frontend-assets/imgs/categories')}}/{{ $val->image }}" width="50" /></td>
                                        <td>{{ $val->name }}</td>
                                        <td>{{ str_replace('_', ' ', $val->slug) }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input active_inactive_btn "
                                                    status="{{ $val->status }}" {{ $val->status == -7 ? '' : '' }}
                                                    table="categories" type="checkbox" id="row_{{ $val->id }}"
                                                    value="{{ Crypt::encryptString($val->id) }}"
                                                    {{ $val->status == 7 ? 'checked' : '' }} style="cursor:pointer">
                                            </div>
                                        </td>
                                        <td>{{ $val->created_at }}</td>
                                        <td>{{ $val->updated_at }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-success me-1 py-1 mt-1 "
                                                wire:click.prevent="edit('{{ Crypt::encryptString($val->id) }}')"
                                                data-bs-toggle="modal" {{-- wire:click.prevent="edit({{ '553453453453454535SDD' }})" data-bs-toggle="modal" --}} {{-- wire:click.prevent="edit({{$val->id}})" data-bs-toggle="modal" --}}
                                                data-bs-target="#editModal" title="Edit"><i
                                                    class="fa-solid fa-file-pen"></i></button>

                                            <button class="btn btn-sm btn-danger py-1 mt-1 del_btn"
                                                {{-- wire:click.prevent="$emit('triggerDelete',{{ $val->id }})" --}}
                                                wire:click.prevent="$emit('triggerDelete','{{ Crypt::encryptString($val->id) }}')"
                                                {{-- wire:click.prevent="destroy('{{ Crypt::encryptString($val->id) }}')" --}} title="Delete"><i
                                                    class="fa-solid fa-trash-can"></i></button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No records found. </td>
                                    </tr>
                                    @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer " wire:key="$categories->id">
                        <div class="row">
                            <div class="col-md-6">
                                {{ $categories->links() }}
                            </div>
                            <div class="col-md-6 text-end">
                                <div>
                                    <p class="text-sm text-gray-700 leading-5">
                                        {!! __('Showing') !!}
                                        <span class="font-medium">{{ $categories->firstItem() }}</span>
                                        {!! __('to') !!}
                                        <span class="font-medium">{{ $categories->lastItem() }}</span>
                                        {!! __('of') !!}
                                        <span class="font-medium">{{ $categories->total() }}</span>
                                        {!! __('results') !!}
                                    </p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                @include('livewire.backend.category.create')
                @include('livewire.backend.category.edit')
            </div>
        </div>
    </section>
</div>
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#name').select2();
            $('#name').on('change', function(e) {
                var data = $('#name').select2("val");
                Livewire.emit('listenerReferenceHere',data);               
                @this.set('name', data);
            });
        });
        document.addEventListener('DOMContentLoaded', function() {

            @this.on('triggerDelete', deleteId => {
                Swal.fire({
                    title: 'Are You Sure?',
                    text: 'This record will be deleted!',
                    type: "warning",
                    showCancelButton: true,
                    // confirmButtonColor: 'var(--success)',
                    // cancelButtonColor: 'var(--primary)',
                    confirmButtonText: 'Delete!'
                }).then((result) => {
                    //if user clicks on delete
                    if (result.value) {
                        // calling destroy method to delete
                        @this.call('destroy', deleteId)
                        // success response
                        //responseAlert({title: session('message'), type: 'success'});

                    } else {
                        Swal.fire({
                            title: 'Operation Cancelled!',
                            type: 'success'
                        });
                    }
                });
            });
        })
    </script>
@endpush
