<?php

namespace App\Imports;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class AttendanceImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $error = '';
        
        foreach ($rows as $key => $row) {
            if ($key == 0) continue; #uploaded rows header

            // $employeeInfo = DB::table('employees')
            // ->leftJoin('branches', 'branches.id', '=', 'employees.branch_id')
            // ->leftJoin('vendors', 'vendors.id', '=', 'employees.vendor_id')
            // ->where('employees.employee_id',$row[4])->get();   
            if (($row[4] == null) || ($row[4] == '')) {
                $error .= 'Row: ' . $key . ' Employee ID NULL! <br/>';
                continue;
            }

            $employeeInfo = Employee::where('employee_id', $row[4])->first();
           if(!$employeeInfo) continue;
            $data[] = array(
                'effective_year'  => $row[0],
                'effective_month'   => $row[1],
                'branch_id' => $employeeInfo->branch_id,
                'vendor_id' => $employeeInfo->vendor_id,
                'employee_id' => $employeeInfo->id,
                'no_of_shift' => $row[6],
                'no_of_days' => $row[7],
                'created_by' => Auth::user()->id
            );
        }
       
        if ($error != "") {
             echo $error;
             exit;
           } else {            
            Attendance::insert($data);
            return 'SUCCESS!';
        }
    }
}
