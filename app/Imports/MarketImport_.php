<?php

namespace App\Imports;

use App\Lib\Webspice;
use App\Models\Area;
use App\Models\Market;
use DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class MarketImport implements ToCollection, WithChunkReading
{
    public function collection(Collection $rows)
    {
        $error = '';
        $existRecord = 0;
        $data = array();
        $columnHeaders = [
            'Area',
            'Market_Name_Eng',
            'Market_Name_Ban',
            'Market_Address',
            'Latitude',
            'Longitude',
        ];
        // dd($columnHeaders);
        foreach ($rows as $key => $row) {

            // dd($row);
            if ($key == 0) {
                $header = $row;
                $match = true;
                $misMatchColumns = array();
                for ($i = 0; $i < count($columnHeaders); $i++) {
                    if ($columnHeaders[$i] !== trim($header[$i])) {
                        array_push($misMatchColumns, $columnHeaders[$i]);
                        $match = false;
                    }
                }
                if (!$match) {
                    $res = implode(', ', $misMatchColumns);
                    return back()->with('error', "Column order or header name ($res) mismatch!.");
                }
                continue;
            }
            #uploaded rows header
            if (($row[0] == null) || ($row[0] == '')
                || ($row[1] == null) || ($row[1] == '')
                || ($row[4] == null) || ($row[4] == '')
                || ($row[5] == null) || ($row[5] == '')
            ) {
                if (($row[0] == null) || ($row[0] == '')) {
                    $error .= 'Row ' . $key . ": '$header[0]' is empty! <br>";
                }
                if (($row[1] == null) || ($row[1] == '')) {
                    $error .= 'Row ' . $key . ": '$header[1]' is empty! <br>";
                }
                // if (($row[2] == null) || ($row[2] == '')) {
                //     $error .= 'Row: ' . $key . ' Market name bangla is empty! <br/>';
                // }
                if (($row[4] == null) || ($row[4] == '')) {
                    $error .= 'Row ' . $key . ": '$header[4]' is empty! <br>";
                }
                if (($row[5] == null) || ($row[5] == '')) {
                    $error .= 'Row ' . $key . ": '$header[5]' is empty! <br>";
                }
            }

            // if (!is_numeric($row[4])) {
            //     $error .= 'Row ' . $key . ": '$header[4]' contain invalid value! <br>";
            // }
            // if (!is_numeric($row[5])) {
            //     $error .= 'Row ' . $key . ": '$header[5]' contain invalid value! <br>";
            // }

            if (!Webspice::isValidCoordinates($row[4], $row[5])) {
                $error .= 'Row ' . $key . ": Invalid coordinates (Latitude, Longitude). <br>";
            }

            $areaInfo = Area::where('value', $row[0])->first();
            if (!$areaInfo) {
                $area = new Area();
                $area->value = $row[0];
                $area->value_bangla = $row[0];
                $area->created_by = Auth::user()->id;
                $area->save();
                $areaId = $area->id;
            } else {
                $areaId = $areaInfo->id;
            }

            if (!$areaId) {
                continue;
            }

            # Check Exist
            $marketExist = Market::where('value', $row[1])->where('area_id', $areaId)->first();
            if ($marketExist) {
                $existRecord++;
                // $existMessage .= 'Row ' . $key . ": data aleady been exist. <br>";
                continue;
            }

            $data[] = array(
                'area_id' => $areaId,
                'value' => $row[1],
                'value_bangla' => $row[2],
                'market_address' => $row[3],
                'latitude' => $row[4],
                'longitude' => $row[5],
                'created_by' => Auth::user()->id,
                'created_at' => now(),
            );
        }

        if ($error != "") {
            return back()->with('error', $error);
        } else {

            if ($existRecord > 0) {
                Session::flash('warning', "$existRecord data already exist!.");
            }
            if (count($data) == 0) {
                return back()->with('error', "No new data found!");
            } else {
                try {
                    DB::beginTransaction();
                    foreach ($data as $item) {
                        $model = new Market($item);
                        $model->save();
                        Webspice::log('markets', $model->id, 'IMPORTED');
                    }
                    Webspice::versionUpdate();
                    Webspice::forgetCache('markets');
                    DB::commit();                    
                    return back()->with('success', count($data) . " data imported successfuly!");
                } catch (\Exception $e) {
                    DB::rollback();
                    return back()->with('error',$e->getMessage());
                }
            }
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
