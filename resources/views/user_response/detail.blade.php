<!-- Modal -->
@foreach ($user_responses as $index => $val)
    <div class="modal fade" id="details-modal-{{ $val->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" ><i class="fa-solid fa-magnifying-glass"></i> User
                        Response Detail ( {{ $val->id }})
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click.prevent='resetInput'></button>
                </div>
                <div class="modal-body">
                    <div wire:loading wire:target="user_responseDetail">
                        <div class="spinner-buser_response spinner-buser_response-sm text-light" role="status">
                            <span class="visually-hidden">Processing...</span>
                        </div>
                    </div>
                    @if (isset($val))
                        <fieldset class="reset">
                            <legend class="reset">User Information</legend>
                            <table class="table">
                                <tr>
                                    <td class="">
                                        Response Date
                                    </td>
                                    <td>: {{ $val->response_date }}</td>
                                    <td>Respondent Type</td>
                                    <td>:
                                        {{ isset($val->registered_user) ? $val->registered_user->respondent_type : '' }}
                                    </td>
                                </tr>                                
                                <tr>
                                    <td>User Name</td>
                                    <td>: {{ isset($val->registered_user) ? $val->registered_user->full_name : '' }}
                                    </td>
                                    <td>Mobile</td>
                                    <td>: {{ isset($val->registered_user) ? $val->registered_user->mobile_no : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>: {{ isset($val->registered_user) ? $val->registered_user->email : '' }}</td>
                                    <td>Division</td>
                                    <td>: {{ isset($val->registered_user) ? $val->registered_user->division : '' }}</td>
                                </tr>
                                <tr>
                                    <td>District</td>
                                    <td>: {{ isset($val->registered_user) ? $val->registered_user->district : '' }}</td>
                                    <td>Thana</td>
                                    <td>: {{ isset($val->registered_user) ? $val->registered_user->thana : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Area</td>
                                    <td>: {{ isset($val->area) ? $val->area->value : '' }}</td>
                                    <td>Market</td>
                                    <td>: {{ isset($val->market) ? $val->market->value : '' }}</td>
                                </tr>
                            </table>
                        </fieldset>
                        <fieldset class="reset">
                            <legend class="reset">Response Details</legend>
                            <table class="table">
                                <thead>
                                    <tr>
                                        {{-- <th>ID</th> --}}
                                        <th>Question</th>
                                        <th>Sub Questin</th>
                                        <th class="text-center">Response</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                            //print_r($val->user_responseDetails);
                            foreach($val->userResponseDetails as $item):
                            ?>
                                    <tr>
                                        <td>{{ isset($item->question) ? $item->question->value : '' }}</td>
                                        <td>{{ isset($item->subQuestion) ? $item->subQuestion->value : '' }}</td>
                                        <td class="text-center">{{ $item->response }}</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </fieldset>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        wire:click.prevent='resetInput'><i class="fa fa-remove"></i> Close</button>

                </div>
            </div>
        </div>
    </div>
@endforeach
