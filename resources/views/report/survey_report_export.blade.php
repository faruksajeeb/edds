<x-app-layout>
    <x-slot name="title">
        Survey Report Export
    </x-slot>
    <div class="row">
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
                <img style="width:200px" src="{{ public_path('img/logo/logo.png') }}" alt="Logo" />
                <h4 id="title" style="padding:5px;background-color:#659ad2;color:#FFFFFF">Salary Statement</h4>
            </div>
        @endif

        <table class="table table-bordered" width="100%">
            @if ($report_format == 'excel')
                <thead>
                    <tr style="">
                        <td style="height:70px;text-align:center; padding-top:10px" colspan="17">

                        </td>
                    </tr>
                    <tr>
                        <td colspan="17" style="text-align:center;padding:10px; font-weight:bold;">
                            <h1>Salary Statement</h1>
                        </td>
                    </tr>

                </thead>
            @endif
            <tbody>
                @php
                    $final_newSalaryTotal = $final_totalSalaryGrand = $final_comissionTotal = $final_vatTotal = $final_totalTotal = $final_taxTotal = $final_grandTotalTotal = $final_netPayableTotal = 0;
                @endphp
                @foreach ($records as $key => $branch)
                    <tr style="">
                        <td colspan="17" style="padding:15px;background-color: #C0C0C0;"><b>Branch:
                                {{ $branch['branch_name'] != '' ? $branch['branch_name'] : 'Not Assigned' }}</b>
                        </td>
                    </tr>
                    <tr style="background-color: #CCC!important">
                        <th style="font-weight:bold">SL No.</th>
                        <th style="font-weight:bold">Name</th>
                        <th style="font-weight:bold">Position</th>
                        <th style="font-weight:bold">Joining Date</th>
                        <th style="font-weight:bold">Service Reference No.</th>
                        <th style="font-weight:bold">Salary</th>
                        <th style="font-weight:bold">Adsent Days</th>
                        <th style="font-weight:bold">Salary After Deduct</th>
                        <th style="font-weight:bold">No. of shifts</th>
                        <th style="font-weight:bold">Total Salary</th>
                        <th style="font-weight:bold">Commission</th>
                        <th style="font-weight:bold">Total</th>
                        <th style="font-weight:bold">VAT @15%</th>
                        <th style="font-weight:bold">Grand Total</th>
                        <th style="font-weight:bold">Tax @ 2%</th>
                        <th style="font-weight:bold">Net Amount Payable</th>
                        <th style="font-weight:bold">A/C Number</th>
                    </tr>
                    @php
                        $newSalaryTotal = $totalSalaryGrand = $comissionTotal = $vatTotal = $totalTotal = $taxTotal = $grandTotalTotal = $netPayableTotal = 0;
                    @endphp
                    @foreach ($branch['emp_records'] as $k => $val)
                        @php
                            $newSalary = $val->present_salary;
                            $day_of_absent = $val->no_of_day_adsent ? $val->no_of_day_adsent : 0;
                            $absentDedection = ($val->present_salary / 30) * $day_of_absent;
                            $salaryAfterDeduct = $val->present_salary - $absentDedection;
                            $noOfShift = $val->no_of_shift ? $val->no_of_shift : 1;
                            $totalSalary = $noOfShift * $salaryAfterDeduct;
                            $commission = ($val->commission_rate * $totalSalary) / 100;
                            $total = $totalSalary + $commission;
                            $vat = ($total * $vat_rate) / 100;
                            $grandTotal = $total + $vat;
                            $tax = ($total * $tax_rate) / 100;
                            $netPayable = $total - $tax;
                        @endphp
                        <tr>
                            <td>{{ ++$k }}</td>
                            <td>{{ $val->employee_name }}</td>
                            <td>{{ $val->designation_name }}</td>
                            <td>{{ $val->joining_date }}</td>
                            <td>{{ $val->service_reference_id }}</td>
                            <td style="text-align: right">{{ number_format($newSalary, 2) }}</td>
                            <td>{{ $day_of_absent }}</td>
                            <td style="text-align: right">{{ number_format($salaryAfterDeduct, 2) }}</td>
                            <td>{{ $noOfShift }}</td>
                            <td style="text-align: right">{{ number_format($totalSalary, 2) }}</td>
                            <td style="text-align: right">{{ number_format($commission, 2) }}</td>
                            <td style="text-align: right">{{ number_format($total, 2) }}</td>
                            <td style="text-align: right">{{ number_format($vat, 2) }}</td>
                            <td style="text-align: right">{{ number_format($grandTotal, 2) }}</td>
                            <td style="text-align: right">{{ number_format($tax, 2) }}</td>
                            <td style="text-align: right">{{ number_format($netPayable, 2) }}</td>
                            <td></td>
                        </tr>
                        @php
                            $newSalaryTotal += $newSalary;
                            $totalSalaryGrand += $totalSalary;
                            $comissionTotal += $commission;
                            $vatTotal += $vat;
                            $totalTotal += $total;
                            $taxTotal += $tax;
                            $grandTotalTotal += $grandTotal;
                            $netPayableTotal += $netPayable;
                        @endphp
                    @endforeach

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="font-weight:bold;text-align: right">{{ number_format($newSalaryTotal, 2) }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="font-weight:bold;text-align: right">{{ number_format($totalSalaryGrand, 2) }}</td>
                        <td style="font-weight:bold;text-align: right">{{ number_format($comissionTotal, 2) }}</td>
                        <td style="font-weight:bold;text-align: right">{{ number_format($totalTotal, 2) }}</td>
                        <td style="font-weight:bold;text-align: right">{{ number_format($vatTotal, 2) }}</td>
                        <td style="font-weight:bold;text-align: right">{{ number_format($grandTotalTotal, 2) }}</td>
                        <td style="font-weight:bold;text-align: right">{{ number_format($taxTotal, 2) }}</td>
                        <td style="font-weight:bold;text-align: right">{{ number_format($netPayableTotal, 2) }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="17">-</td>
                    </tr>
                    @php
                        $final_newSalaryTotal += $newSalaryTotal;
                        $final_totalSalaryGrand += $totalSalaryGrand;
                        $final_comissionTotal += $comissionTotal;
                        $final_vatTotal += $vatTotal;
                        $final_totalTotal += $totalTotal;
                        $final_taxTotal += $taxTotal;
                        $final_grandTotalTotal += $grandTotalTotal;
                        $final_netPayableTotal += $netPayableTotal;
                    @endphp
                @endforeach
                <tr>
                    <td colspan="17">-</td>
                </tr>
                <tr>
                    <td colspan="17">-</td>
                </tr>
                <tr>
                    <td colspan="3">Grand Total</td>
                    <td></td>
                    <td></td>
                    <td style="font-weight:bold;text-align: right">{{ number_format($final_newSalaryTotal, 2) }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="font-weight:bold;text-align: right">{{ number_format($final_totalSalaryGrand, 2) }}</td>
                    <td style="font-weight:bold;text-align: right">{{ number_format($final_comissionTotal, 2) }}</td>
                    <td style="font-weight:bold;text-align: right">{{ number_format($final_vatTotal, 2) }}</td>
                    <td style="font-weight:bold;text-align: right">{{ number_format($final_totalTotal, 2) }}</td>
                    <td style="font-weight:bold;text-align: right">{{ number_format($final_taxTotal, 2) }}</td>
                    <td style="font-weight:bold;text-align: right">{{ number_format($final_grandTotalTotal, 2) }}</td>
                    <td style="font-weight:bold;text-align: right">{{ number_format($final_netPayableTotal, 2) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="7" style="text-align: right;">Payment Deduction
                        ({{ $payment_deduction_info ? $payment_deduction_info->reason : '' }})</td>
                    <td style="text-align: right; font-weight:bold">
                        {{ $payment_deduction_info ? number_format($payment_deduction_info->amount, 2) : '' }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right; font-weight:bold">
                        @php
                            $deductionAmt = 0;
                            $payment_deduction_info ? ($deductionAmt = $payment_deduction_info->amount) : ($deductionAmt = 0);
                        @endphp
                        {{ number_format($final_netPayableTotal - $deductionAmt, 2) }}
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>

    </div>
    @push('scripts')
        <script></script>
    @endpush
</x-app-layout>
