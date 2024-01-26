@push('styles')
<style>
    .drag-icon {
        font-size: 25px;
        color: darkgray;
        cursor: pointer;
    }
</style>
@endpush
<x-app-layout>
    <x-slot name="title">
        App Footer Logos
    </x-slot>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title py-1"><i class="fa fa-table"></i>
                                @if (request()->get('status') == 'archived')
                                Deleted
                                @endif App Footer Logos
                            </h5>
                        </div>
                        <div class="col-md-4">
                            <nav aria-label="breadcrumb" class="float-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                                    <li class="breadcrumb-item " aria-current="page">
                                        @if (request()->get('status') == 'archived')
                                        Deleted
                                        @endif App Footer Logos
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @if (request()->get('status') != 'archived')
                            <a href="{{ url('/app_footer_logos?status=archived') }}">Deleted App Footer Logos</a>
                            @else
                            <a href="{{ url('/app_footer_logos') }}">App Footer Logos</a>
                            @endif
                            @if (request()->get('status') == 'archived' && $app_footer_logos->total() > 0)
                            @can('app_footer_logo.restore')
                            <div class="float-end">
                                <a href="" class="btn btn-primary btn-sm btn-restore-all" onclick="event.preventDefault(); restoreAllConfirmation()"><i class="fa-solid fa-trash-arrow-up"></i> Restore All</a>
                                <form id="restore-all-form" action="{{ route('app_footer_logos.restore-all') }}" style="display:inline" method="POST">
                                    @method('POST')
                                    @csrf
                                </form>
                            </div>
                            @endcan
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">

                        </div>
                        <div class="col-md-3">
                            @can('app_footer_logo.create')
                            @if (request()->get('status') != 'archived')
                            <a href="{{ route('app_footer_logos.create') }}" class="btn btn-xs btn-primary float-end" name="create_new" type="button">
                                <i class="fa-solid fa-plus"></i> Add App Footer Logo
                            </a>
                            @endif
                            @endcan
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="">

                        <div class="table-responsive">
                            <table class="table table-sm mb-0 table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap" colspan="2">Order</th>
                                        <th>Status </th>
                                        <th>Logo</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable" tablename="tbl_logos">
                                    @forelse ($app_footer_logos as $index => $val)
                                    <tr id="{{ $val->id }}">
                                        <td class=''>
                                            <span class="sort bg-red">
                                                <i class="fa-solid fa-up-down-left-right drag-icon"></i>
                                            </span>
                                        </td>
                                        <td>{{ $index + $app_footer_logos->firstItem() }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                @if (request()->get('status') == 'archived')
                                                <span class="badge bg-secondary">Archived</span>
                                                @else
                                                @can('app_footer_logo.edit')
                                                <input class="form-check-input active_inactive_btn " status="{{ $val->status }}" {{ $val->status == -7 ? '' : '' }} table="tbl_logos" type="checkbox" id="row_{{ $val->id }}" value="{{ Crypt::encryptString($val->id) }}" {{ $val->status == 7 ? 'checked' : '' }} style="cursor:pointer">
                                                @endif
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-nowrap ">
                                            @php
                                            // Extract the base64 encoded data from the string
                                            $base64Data = substr($val->logo_base64, strpos($val->logo_base64, ',') + 1);

                                            // Create a data URL for the image
                                            $dataUrl = 'data:image/png;base64,' . $base64Data;
                                            @endphp
                                            <!-- <img src="{{ $dataUrl }}" alt="Base64 Image" width="100" height="100"> -->
                                            <img src="{{ $val->logo_url }}" alt="Logo" width="100" height="100">
                                        </td>

                                        <td class="text-nowrap text-center">
                                            @if (request()->get('status') == 'archived')
                                            {{-- restore button --}}
                                            @can('app_footer_logo.restore')
                                            <a href="" class="btn btn-primary btn-sm btn-restore-{{ $val->id }}" onclick="event.preventDefault(); restoreConfirmation({{ $val->id }})"><i class="fa-solid fa-trash-arrow-up"></i> Restore</a>
                                            <form id="restore-form-{{ $val->id }}" action="{{ route('app_footer_logos.restore', Crypt::encryptString($val->id)) }}" method="POST" style="display: none">
                                                @method('POST')
                                                @csrf
                                            </form>
                                            @endcan
                                            {{-- force delete button --}}
                                            @can('app_footer_logo.force_delete')
                                            <a href="" class="btn btn-danger btn-sm btn-force-delete-{{ $val->id }} disabled" onclick="event.preventDefault(); forceDelete({{ $val->id }})" disabled><i class="fa-solid fa-remove"></i> Force Delete</a>
                                            <form id="force-delete-form-{{ $val->id }}" style="display: none" action="{{ route('app_footer_logos.force-delete', Crypt::encryptString($val->id)) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                            @endcan
                                            @else
                                            {{-- edit button --}}
                                            @can('app_footer_logo.edit')
                                            @if ($val->status == 7)
                                            <a href="{{ route('app_footer_logos.edit', Crypt::encryptString($val->id)) }}" class="btn btn-warning btn-sm"><i class="fa-solid fa-pencil"></i>
                                                Edit</a>
                                            @endif
                                            @endcan
                                            {{-- delete button --}}
                                            @can('app_footer_logo.delete')
                                            <a href="" class="btn btn-danger btn-sm btn-delete-{{ $val->id }}" onclick="event.preventDefault(); confirmDelete({{ $val->id }})"><i class="fa-solid fa-trash"></i> Delete</a>
                                            <form id="delete-form-{{ $val->id }}" style="display: none" action="{{ route('app_footer_logos.destroy', Crypt::encryptString($val->id)) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                            @endcan
                                            @endif
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
                        {{ $app_footer_logos->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script></script>
    @endpush
</x-app-layout>