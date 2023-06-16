<!-- Modal -->
@foreach ($user_responses as $index => $val)
    <div class="modal fade" id="details-modal-{{ $val->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-magnifying-glass"></i> User
                        Response Detail 
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
                            <legend class="reset">Respondent Information</legend>
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
                                    <td>Respondent Name</td>
                                    <td>: {{ isset($val->registered_user) ? $val->registered_user->full_name : '' }}
                                    </td>
                                    <td>Respondent Mobile</td>
                                    <td>: {{ isset($val->registered_user) ? $val->registered_user->mobile_no : '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Respondent Email</td>
                                    <td>: {{ isset($val->registered_user) ? $val->registered_user->email : '' }}</td>
                                    <td>Response Division</td>
                                    {{-- <td>: {{ isset($val->registered_user) ? $val->registered_user->division : '' }}</td> --}}
                                    <td>: {{ isset($val->response_division) ? $val->response_division : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Response District</td>
                                    {{-- <td>: {{ isset($val->registered_user) ? $val->registered_user->district : '' }}</td> --}}
                                    <td colspan="3">: {{ isset($val->response_district) ? $val->response_district : '' }}</td>
                                    {{-- <td>Thana</td>
                                    <td>: {{ isset($val->registered_user) ? $val->registered_user->thana : '' }}</td> --}}
                                </tr>
                                {{-- <tr>
                                    <td>Area</td>
                                    <td>: {{ isset($val->area) ? $val->area->value : '' }}</td>
                                    <td>Market</td>
                                    <td>: {{ isset($val->market) ? $val->market->value : (($val->market_id==-100)?$val->market_other:'')}}</td>
                                </tr> --}}
                                <tr>
                                    <td>Response Area</td>
                                    <td colspan="2">: {{ isset($val->formatted_address) ? $val->formatted_address : '' }}</td>
                                    <td > <a href="https://www.google.com/maps/search/?api=1&query=<?php echo $val->response_location ?>" target="_blank" class="float-end"><i class="fa-solid fa-location-dot"></i> Response Location</a></td>
                                </tr>
                            </table>
                            <a href="https://www.google.com/maps/search/?api=1&query=<?php echo $val->location ?>" target="_blank" class="float-start">User Location</a>
                           

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
                            // $val->userResponseDetails->count();
                            $quesId = '';
                            foreach($val->userResponseDetails as $item):
                                    $file = $val->id.'_'.$item->question_id.'.jpg';
                            ?>
                                    <tr>
                                        <td>
                                            {{-- @if ($loop->iteration == 1) --}}
                                            @if ($quesId != $item->question->id)
                                                {{ isset($item->question) ? $item->question->value : '' }}
                                                <br/>
                                                @if (Storage::disk('external')->exists($file))
                                                    <a href="../edds_app/tmp_img/{{ $val->id . '_' . $item->question_id }}.jpg"
                                                        target="_blank">Uploaded Image</a>
                                                    {{-- <img src="../edds_app/tmp_img/{{$item->question_id.'_'.$item->sub_question_id}}.jpg" width="250" height="250" alt="Low-Resolution Image"> --}}
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ isset($item->subQuestion) ? $item->subQuestion->value : '' }}</td>
                                        <td class="text-center">{{ $item->response }}</td>
                                    </tr>

                                    @php
                                        $quesId = $item->question->id;
                                    @endphp
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
