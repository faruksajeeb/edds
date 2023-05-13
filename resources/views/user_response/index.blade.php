<x-app-layout>
    <x-slot name="title">
        User Responses
    </x-slot>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title py-1"><i class="fa fa-table"></i>
                                @if (request()->get('status') == 'archived')
                                    Archived
                                @endif User Responses
                            </h5>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Response</a></li>
                                    <li class="breadcrumb-item " aria-current="page">
                                        @if (request()->get('status') == 'archived')
                                            Archived
                                        @endif User Responses
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @if (request()->get('status') != 'archived')
                                <a href="{{ url('/user_responses?status=archived') }}">Archived User Responses</a>
                            @else
                                <a href="{{ url('/user_responses') }}">User Responses</a>
                            @endif
                            @if ((request()->get('status') == 'archived') && ($user_responses->total() >0))
                                @can('user_response.restore')
                                    <div class="float-end">
                                        <a href="" class="btn btn-primary btn-sm btn-restore-all"
                                            onclick="event.preventDefault(); restoreAllConfirmation()"><i
                                                class="fa-solid fa-trash-arrow-up"></i> Restore All</a>
                                        <form id="restore-all-form" action="{{ route('user_responses.restore-all') }}"
                                            style="display:inline" method="POST">
                                            @method('POST')
                                            @csrf
                                        </form>
                                    </div>
                                @endcan
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="">
                        <form action="" method="GET">
                            @csrf
                            <input type="hidden" name="status"
                                value="{{ request()->get('status') == 'archived' ? 'archived' : '' }}">
                            <div class="row">
                                <div class="col-md-3 col-sm-12">
                                    <select name="search_respodent" class="form-select" id="search_respodent">
                                        <option value="">Select respondent</option>
                                        @foreach ($respondents as $val)                                    
                                            <option value="{{$val->id}}" {{ $val->id==old('responden_id')?'selected':''}}>{{$val->option_value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12 px-0">
                                    <div class="input-group">
                                        <input type="text" name="search_text" value="" class="form-control"
                                            placeholder="Search by text">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary mx-1 filter_btn" name="submit_btn" type="submit"
                                                value="search">
                                                <i class="fa fa-search"></i> Filter
                                            </button>
                                            <a href='{{ request()->get('status') == 'archived' ? url('/user_responses?status=archived') : url('/user_responses') }}'
                                                class="btn btn-xs btn-primary me-1 refresh_btn"><i class="fa fa-refresh"></i></a>
                                            @can('user_response.export')
                                                {{-- <button class="btn btn-xs btn-danger float-end " name="submit_btn"
                                                value="pdf" type="submit">
                                                <i class="fa-solid fa-download"></i> PDF
                                            </button> --}}
                                                {{-- <button class="btn btn-xs btn-info float-end me-1 export_btn" name="submit_btn"
                                                    value="csv" type="submit">
                                                    <i class="fa-solid fa-download"></i> CSV
                                                </button> --}}

                                                <button class="btn btn-xs btn-success float-end me-1 export_btn" name="submit_btn"
                                                    value="export" type="submit">
                                                    <i class="fa-solid fa-download"></i> Export
                                                </button>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    @can('user_response.create')
                                        {{-- <a href="{{ route('user_responses.create') }}"
                                            class="btn btn-xs btn-outline-primary float-end" name="create_new"
                                            type="button">
                                            <i class="fa-solid fa-plus"></i> Create Response
                                        </a> --}}
                                    @endcan
                                </div>

                            </div>
                        </form>
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Gender</th>
                                    <th>Respondent</th>
                                    <th>Response At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user_responses as $index => $val)
                                    <tr>
                                        <td>{{ $index + $user_responses->firstItem() }}</td>
                                        <td>{{ $val->full_name }}</td>
                                        <td>{{ $val->email }}</td>
                                        <td>{{ $val->mobile_no }}</td>
                                        <td>{{ $val->gender }}</td>
                                        <td>{{ isset($val->respondent) ? $val->respondent->option_value : '' }}</td>
                                      
                                        <td>{{ $val->created_at }}</td>
                        <td class="text-nowrap">
                            @if (request()->get('status') == 'archived')
                                {{-- restore button --}}
                                @can('user_response.restore')
                                    <a href="" class="btn btn-primary btn-sm btn-restore-{{ $val->id }}"
                                        onclick="event.preventDefault(); restoreConfirmation({{ $val->id }})"><i
                                            class="fa-solid fa-trash-arrow-up"></i> Restore</a>
                                    <form id="restore-form-{{ $val->id }}"
                                        action="{{ route('user_responses.restore', Crypt::encryptString($val->id)) }}"
                                        method="POST" style="display: none">
                                        @method('POST')
                                        @csrf
                                    </form>
                                @endcan
                                {{-- force delete button --}}
                                @can('user_response.force_delete')
                                    <a href="" class="btn btn-danger btn-sm btn-force-delete-{{ $val->id }}"
                                        onclick="event.preventDefault(); forceDelete({{ $val->id }})"><i
                                            class="fa-solid fa-remove"></i> Force Delete</a>
                                    <form id="force-delete-form-{{ $val->id }}" style="display: none"
                                        action="{{ route('user_responses.force-delete', Crypt::encryptString($val->id)) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                @endcan
                            @else
                                {{-- edit button --}}
                                @can('user_response.edit')
                                    @if ($val->status == 1)
                                        {{-- <a href="{{ route('user_responses.edit', Crypt::encryptString($val->id)) }}"
                                            class="btn btn-outline-warning btn-sm"><i class="fa-solid fa-pencil"></i> Edit</a> --}}
                                    @endif
                                @endcan
                                 {{-- edit button --}}
                                 @can('user_response.verify')
                                 {{-- @if ($val->status == 1) --}}
                                     <a href=""
                                         class="btn btn-outline-success btn-sm"><i class="fas fa-check"></i> Verify</a>
                                 {{-- @endif --}}
                             @endcan
                             <button class="btn btn-sm btn-secondary me-1 mt-1" data-bs-toggle="modal" data-bs-target="#detailModal" 
                                            wire:click.prevent="orderDetail('{{ Crypt::encryptString($val->id) }}')">
                                                <i class="fa-solid fa-magnifying-glass-plus"></i></button>
                                {{-- delete button --}}
                                @can('user_response.delete')
                                    <a href="" class="btn btn-outline-danger btn-sm btn-delete-{{ $val->id }}"
                                        onclick="event.preventDefault(); confirmDelete({{ $val->id }})"><i
                                            class="fa-solid fa-trash"></i> Delete</a>
                                    <form id="delete-form-{{ $val->id }}" style="display: none"
                                        action="{{ route('user_responses.destroy', Crypt::encryptString($val->id)) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                @endcan
                            @endif

                        </td>
                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                        {{ $user_responses->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
        </div>

        @push('scripts')
            <script></script>
        @endpush
    </x-app-layout>
