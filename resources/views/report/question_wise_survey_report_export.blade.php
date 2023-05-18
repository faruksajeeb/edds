<style>
    .title {
        style="background-color: #CCC";
    }

    table {
        border-collapse: collapse;
        font-size: 10px;
    }

    table tbody td,
    th {
        border: 1px solid #000000;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

@if ($report_format == 'pdf')
    <div id="header" style="text-align:center">
        <img style="width:200px" src="{{ public_path('/logo.png') }}" alt="Logo" />
        <h4 id="title" style="padding:5px;background-color:#F5DEB3;color:#000000">Survey Report</h4>
    </div>
@endif

<table class="table table-bordered" width="100%">
    <thead>
        @if ($report_format == 'export')
            <tr style="">
                <td style="height:70px;text-align:center; padding-top:10px" colspan="8">

                </td>
            </tr>
            <tr>
                <td colspan="8" style="text-align:center;padding:10px; font-weight:bold;background-color:#F5DEB3;color:#000000">
                    <h1>Survey Report</h1>
                </td>
            </tr>
        @endif


    </thead>
    <tbody>

        <tr style="font-weight:bold;text-align:left">
            <td colspan="2">
                Division: {{ $division }}
            </td>
            <td colspan="2">
                District: {{ $district }}
            </td>
            <td colspan="2">
                Thana: {{ $thana }}
            </td>
            <td colspan="2" style="text-align:right!important">
                Date From: {{ $date_from }} Date To: {{ $date_to }}
            </td>
        </tr>
        @foreach ($records as $key => $category)
            <tr style="">
                <td colspan="8" style="padding:15px;background-color: #F5DEB3;"><b># Category:
                        {{ $category['category_name'] != '' ? $category['category_name'] : 'Not Assigned' }}</b>
                </td>
            </tr>


            @foreach ($category['category_records'] as $k => $question)
                <tr style="">
                    <td colspan="8" style="padding:15px;background-color: #F5DEB3;"><b>## Question:
                            {{ $question['question'] != '' ? $question['question'] : 'Not Assigned' }}</b>
                    </td>
                </tr>
                <tr style="font-weight:bold">
                    <td>#</td>
                    <td>Response ID</td>
                    <td>Response Date</td>
                    <td>Response By</td>
                    <td>Mobile No</td>
                    <td>Area</td>
                    <td>Market</td>
                    {{-- <td>Category</td>
            <td>Question</td> --}}
                    {{-- <td>Question ID</td> --}}
                    {{-- <td>Sub ID</td> --}}
                    <td>
                        @php
                            $subQuestions = \App\Models\SubQuestion::where('question_id', $question['question_id'])
                                ->where('status', 1)
                                ->get();
                        @endphp

                        {{-- <table width="100%">
                            <tr>
                                @foreach ($subQuestions as $k => $val)
                                    <td style="text-align:center">{{ $val->value }}</td>
                                @endforeach
                            </tr>
                        </table> --}}
                        Response
                    </td>

                </tr>
                @foreach ($question['records'] as $k => $val)
                    <tr>
                        <td>{{ $k + 1 }}</td>
                        <td>{{ $val->id }}</td>
                        <td>{{ $val->response_date }}</td>
                        <td>{{ $val->full_name }}</td>
                        <td>{{ $val->mobile_no }}</td>
                        <td>{{ $val->area_name }}</td>
                        <td>{{ $val->market_name }}</td>
                        {{-- <td>{{ $val->category_name }}</td>
                    <td>{{ $val->question }}</td> --}}
                        {{-- <td>{{ $val->question_id }}</td>
                        <td>{{ $val->sub_question_id }}</td> --}}
                        <td style="text-align:left">
                            {{-- <table width='100%'> --}}

                            @php
                                $ResValue = '';
                            @endphp
                            @foreach ($subQuestions as $k => $Subval)
                                @php
                                    $data = \App\Models\UserResponseDetail::select('sub_questions.value', 'user_response_details.response')
                                        ->leftJoin('user_responses', 'user_responses.id', '=', 'user_response_details.response_id')
                                        ->leftJoin('sub_questions', 'sub_questions.id', '=', 'user_response_details.sub_question_id')
                                        ->where('user_response_details.question_id', $val->question_id)
                                        ->where('user_response_details.sub_question_id', $Subval->id)
                                        ->where('user_responses.id', $val->id)
                                        ->first();
                                    // $response = $data->response;
                                    if ($data) {
                                        // echo gettype((int) $data->response);
                                        if (is_numeric($data->response)) {
                                            $ResValue .= isset($data->response) ? $data->value . ': ' . $data->response . ', ' : '';
                                        } else {
                                            $ResValue .= isset($data->response) ? $data->response . ', ' : '';
                                        }
                                    }
                                    
                                @endphp
                                {{-- @if ($data)
                                    <tr><td>{{$data->value}}</td><td>{{$data->response}}</td></tr>
                                @endif --}}
                                {{-- <td style="text-align:center">{{ (isset($data))?$data->response:''; }}</td> --}}
                            @endforeach
                            {{ $ResValue }}

                            {{-- </table> --}}
                        </td>
                    </tr>
                @endforeach
            @endforeach
        @endforeach
    </tbody>
</table>
