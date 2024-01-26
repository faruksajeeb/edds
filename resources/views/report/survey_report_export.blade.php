<style>
    table {
        border-collapse: collapse;
        font-size: 14px;

        /*Optional: Set width to 100% as well */
        /* border-collapse: collapse; Optional: To collapse borders between cells */
    }

    .mother,
    .child {
        height: 100%;
        width: 100%;
    }



    .grandMother th {
        border: 1px solid #CCCCCC;
    }

    .mother td {
        border-bottom: 1px solid #CCCCCC;
    }

    .child td {
        border: 1px solid #CCCCCC;
    }


    @page {
        margin: 1.5cm;
        /* Set margins for all sides */


    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        /* margin: 1cm;  */
        /* Set additional margins for content inside the page */
    }
</style>

@php
$colspan = 7;

@endphp

<div class="row" style="width:1000px;margin:0 auto">
    <div class="col-md-10 offset-md-1 text-center">
        @if ($report_format == 'pdf' || $report_format == 'view')
        <div id="header" style="text-align:center">
            <img style="width:200px" src="{{ asset('/uploads/'.$theme_settings->website_logo) }}" alt="Logo" />
            <h4 id="title" style="padding:5px;background-color:#F5DEB3;color:#000000">Survey Report</h4>
            <small>Date Range: {{$date_from}} - {{$date_to}}</small>
        </div>
        @endif

        @if(count($records)>0)
        <table class="table table-bordered grandMother ms-auto" border="1" width="">
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
                    <th style="width:40px">SL NO</th>
                    <th>Response Date</th>
                    <th>Entry Date</th>
                    <th>Location</th>
                    <th style="text-align:center;width:650px;" colspan="2">Responses</th>
                </tr>
                <!-- <tr>
                    <th style="width:40px" rowspan="2">SL NO</th>
                    <th rowspan="2">Response Date</th>
                    <th rowspan="2">Entry Date</th>
                    <th rowspan="2">Location</th>
                    <th style="text-align:center;width:650px;" colspan="2">Responses</th>
                </tr> -->
                <!-- <tr>
                    <th style="width:325px">Heading</th>
                    <th style="width:325px">Answer</th>
                </tr> -->
                @foreach($records as $val)
                @if(count($val['responses'])>0)
                <tr>
                    <td style="padding:5px; border:1px solid #CCCCCC;">{{ $val['sl'] }}</td>
                    <td style="padding:5px; border:1px solid #CCCCCC;width:60px">{{ $val['response_date'] }}</td>
                    <td style="padding:5px; border:1px solid #CCCCCC;width:150px;white-space: nowrap;">{{ $val['created_at'] }}</td>
                    <td style="padding:5px; border:1px solid #CCCCCC; width:200px">{{ $val['location'] }}</td>
                    <td colspan="2" style="max-width:650px; min-width:650px; border-top:1px solid #CCC; padding:0; ">
                        <table class="mother" cellspacing="0" cellpadding="0" style="max-width:650px;min-width:650px;height:100%!important">
                            <tr>
                                <td style="padding:5px;width:325px;font-weight:bold;border:1px solid #CCC">Heading</td>
                                <td style="padding:5px;width:325px;font-weight:bold;border:1px solid #CCC">Answer</td>
                            </tr>
                            @foreach($val['responses'] as $resVal)
                            @if(count($resVal['answer'])>0)
                            <tr>
                                <td style="padding:5px;width:325px!important">{{ $resVal['heading'] }}</td>
                                <td style="width:325px!important;">
                                    <table class="child" border="0" style="border:none;max-width:325px;min-width:325px; height:100%!important">
                                        <tr>
                                            <td style="padding:5px;max-width:200px!important;min-width:200px!important;border:1px solid #CCC">Item</td>
                                            <td style="padding:5px;max-width:125px!important;min-width:125px!important;border:1px solid #CCC">Response</td>
                                        </tr>
                                        @foreach($resVal['answer'] as $ansVal)
                                        <tr>
                                            <td style="max-width:200px!important;min-width:200px!important;padding:5px;overflow:hidden">{{$ansVal['q']}}</td>
                                            <td style="max-width:125px!important;min-width:125px!important;padding:5px;overflow:hidden!important">{{$ansVal['a']}}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </table>
                    </td>

                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
        @else

        <h4 id="title" style="padding:5px;background-color:#F5DEB3;color:red">No record found!</h4>

        @endif


    </div>
</div>