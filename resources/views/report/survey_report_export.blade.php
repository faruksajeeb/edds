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
                <td style="height:70px;text-align:center; padding-top:10px" colspan="7">

                </td>
            </tr>
            <tr>
                <td colspan="7" style="text-align:center;padding:10px; font-weight:bold;background-color:#F5DEB3;color:#000000">
                    <h1>Survey Report</h1>
                </td>
            </tr>
        @endif
       
        
    </thead>
    <tbody>

        <tr style="font-weight:bold;text-align:left">
            <td>
                Division: {{ $division }}
            </td>
            <td colspan="2">
                District: {{ $district }}
            </td>
            <td colspan="2">
                Thana: {{ $thana }}
            </td>
            <td colspan="2" style="text-align:right!important">
                Date From: {{ $date_from }}  Date To: {{ $date_to }}
            </td>
        </tr>
        @foreach ($records as $key => $category)
            <tr style="">
                <td colspan="7" style="padding:15px;background-color: #F5DEB3;"><b># Category:
                        {{ $category['category_name'] != '' ? $category['category_name'] : 'Not Assigned' }}</b>
                </td>
            </tr>


            @foreach ($category['category_records'] as $k => $question)
                <tr style="">
                    <td colspan="7" style="padding:15px;background-color: #F5DEB3;"><b>## Question:
                            {{ $question['question'] != '' ? $question['question'] : 'Not Assigned' }}</b>
                    </td>
                </tr>
                @foreach ($question['sub_records'] as $k => $sub_question)
                    <tr style="">
                        <td colspan="7" style="padding:15px;background-color: #F5DEB3;"><b>### Sub Question:
                                {{ $sub_question['sub_question'] != '' ? $sub_question['sub_question'] : 'Not Assigned' }}</b>
                        </td>
                    </tr>
                    <tr style="font-weight:bold">
                        <td>#</td>
                        <td>Response Date</td>
                        <td>Response By</td>
                        <td>Mobile No</td>
                        <td>Area</td>
                        <td>Market</td>
                        {{-- <td>Category</td>
                <td>Question</td> --}}
                        {{-- <td>Sub Question</td> --}}
                        <td style="text-align:center">Response</td>
                    </tr>
                    @php
                        $subQuestionTotal = 0;
                    @endphp
                    @foreach ($sub_question['records'] as $k => $val)
                        <tr>
                            <td>{{ $k + 1 }}</td>
                            <td>{{ $val->response_date }}</td>
                            <td>{{ $val->full_name }}</td>
                            <td>{{ $val->mobile_no }}</td>
                            <td>{{ $val->area_name }}</td>
                            <td>{{ $val->market_name }}</td>
                            {{-- <td>{{ $val->category_name }}</td>
                    <td>{{ $val->question }}</td> --}}
                            {{-- <td>{{ $val->sub_question }}</td> --}}
                            <td style="text-align:center">{{ $val->response }}</td>
                        </tr>
                        @php                            
                            if(is_numeric($val->response)){
                                $subQuestionTotal += $val->response;
                            }else{
                                $subQuestionTotal ++;
                            }
                        @endphp
                    @endforeach
                    <tr style="font-weight:bold">
                        <td colspan="6">Total ({{ $sub_question['sub_question'] }} )</td>
                        <td style="text-align:center">{{ $subQuestionTotal }}</td>
                    </tr>
                    <tr>
                        <td colspan="7"></td>
                    </tr>
                @endforeach
            @endforeach
        @endforeach
    </tbody>
</table>
