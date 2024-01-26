<style>
    .title {
        style="background-color: #CCC";
    }

    table {
        border-collapse: collapse;
        font-size: 14px;
    }

     .grandMother th
     {
        border: 1px solid #CCCCCC;
    } 

    .mother td {
        border-bottom: 1px solid #CCCCCC;
    }
    .child td {
        border: 1px solid #CCCCCC;
    } 


    @page {
            margin: 1cm; /* Set margins for all sides */
           

        }
    body {
        font-family: Arial, Helvetica, sans-serif;
        margin: 1cm; /* Set additional margins for content inside the page */
    }
</style>

@php
$colspan = 7;
@endphp
@if ($report_format == 'pdf' || $report_format == 'view')
<div id="header" style="text-align:center">
    <img style="width:200px" src="{{ asset('/uploads/'.$theme_settings->website_logo) }}" alt="Logo" />
    <h4 id="title" style="padding:5px;background-color:#F5DEB3;color:#000000">Survey Report</h4>
    <small>Date Range: {{$date_from}} - {{$date_to}}</small>
</div>
@endif

<table class="table table-bordered grandMother" border="0" width="100%">
    <thead>
        @if ($report_format == 'export')
        <tr style="">
            <td style="height:70px;text-align:center; padding-top:10px" colspan="{{$colspan}}">

            </td>
        </tr>
        <tr>
            <td colspan="{{$colspan}}" style="text-align:center;padding:10px; font-weight:bold;background-color:#F5DEB3;color:#000000">
                <h1>Survey Report</h1>
                <small>Date Range: {{$date_from}} - {{$date_to}}</small>
            </td>
        </tr>
        @endif


    </thead>
    <tbody>
     
        <tr>
            <th style="width:40px" rowspan="2">SL NO</th>
            <th rowspan="2">Response Date</th>
            <th rowspan="2">Entry Date</th>
            <th rowspan="2">Location</th>
            <th style="text-align:center;width:650px;" colspan="2">Responses</th>
            <th rowspan="2" style="width:100px">Images</th>
        </tr>
        <tr>
            <th style="width:325px">Heading</th>
            <th style="width:325px">Answer</th>
        </tr>
        @foreach($records as $val)
        <tr>
            <td style="padding:5px; border:1px solid #CCCCCC;">{{ $val['sl'] }}</td>
            <td style="padding:5px; border:1px solid #CCCCCC;width:60px" >{{ $val['response_date'] }}</td>
            <td style="padding:5px; border:1px solid #CCCCCC;width:100px" >{{ $val['created_at'] }}</td>
            <td style="padding:5px; border:1px solid #CCCCCC; width:150px" >{{ $val['location'] }}</td>
            <td colspan="2" style="width:650px; border-top:1px solid #CCCCCC; padding:0; ">
                <table class="mother"  cellspacing="0" cellpadding="0" style=""  style="width:650px;">
                    <!-- <tr>
                        <td style="padding:5px;width:325px;font-weight:bold" >Heading</td>
                        <td style="padding:5px;width:325px;font-weight:bold" >Answer</td>
                    </tr> -->
                    @foreach($val['responses'] as $resVal)
                    <tr>
                        <td  style="padding:5px;width:50%!important">{{ $resVal['heading'] }}</td>
                        <td  style="width:50%">
                            <table class="child" style="border:none" border="0"  style="width:325px">
                                <!-- <tr>
                                    <td width="50%">Ques</td>
                                    <td width="50%">Ans</td>
                                </tr> -->
                                @foreach($resVal['answer'] as $ansVal)
                                    <tr >
                                        <td style="width:200px;padding:5px;">{{$ansVal['q']}}</td>
                                        <td style="width:200px;padding:5px;">{{$ansVal['a']}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </td>
            <td style="border:1px solid #CCCCCC">
                @foreach($val['images'] as $imgPath)
                <a href="{{$imgPath}}" target="_blank">Image</a>
                @endforeach
            </td>
        </tr>
        @endforeach
    </tbody>
</table>