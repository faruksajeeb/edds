<!-- Modal -->
@foreach ($user_responses as $index => $val)
<div class="modal fade" id="details-modal-{{$val->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-magnifying-glass-plus"></i> User Response Detail
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  wire:click.prevent='resetInput'></button>
                </div>
                <div class="modal-body">
                    <div wire:loading wire:target="user_responseDetail">
                        <div class="spinner-buser_response spinner-buser_response-sm text-light" role="status">
                            <span class="visually-hidden">Processing...</span>
                        </div>
                    </div>
                    @if (isset($val))
                   <table class="table">
                        <tr>
                            <td >Response ID #</td>
                            <td >: {{ $val->id }}</td>
                            <td  class="">
                                
                                   Response At
                               
                            </td>
                            <td>: {{$val->created_at}}</td>
                        </tr>
                        <tr>
                            <td>User Name</td>
                            <td>: {{  isset($val->registered_user)?$val->registered_user->full_name:''}}</td>
                            <td>Mobile</td>
                            <td>: {{ isset($val->registered_user)?$val->registered_user->mobile_no:''}}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>: {{isset($val->registered_user)?$val->registered_user->email:''}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                   </table>
                    <table class="table">
                        <thead>
                            <tr>
                                {{-- <th>ID</th> --}}
                                <th>Question</th>
                                <th>Sub Questin</th>
                                <th>Response</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //print_r($val->user_responseDetails);
                            foreach($val->userResponseDetails as $item):
                            ?>
                            <tr>
                                <td>{{ isset($item->question)?$item->question->value:'' }}</td>
                                <td>{{ isset($item->subQuestion)?$item->subQuestion->value:'' }}</td>
                                <td>{{ $item->response }}</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>                         
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click.prevent='resetInput'><i class="fa fa-remove"></i> Close</button>

                </div>
        </div>
    </div>   
</div>
@endforeach
