<?php
namespace App\Imports;

use App\Lib\Webspice;
use App\Models\Area;
use App\Models\Market;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithValidation;

class AreaListImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation
{
    use RemembersRowNumber;
    private $rows = 0;
    private $insertedRows = 0;
    private $alreadyExistRows = 0;
    private $error = '';

    public function rules(): array
    {
        return [
            'area_name_english' => [
                'required',
                'string',
            ],
            'area_name_bangla' => [
                'required',
                'string',
            ],
            'latitude' => ['required', 'numeric',
                'min:-90', 'max:90',
            ],
            'longitude' => ['required', 'numeric',
                'min:-180', 'max:180',
            ],
        ];
    }

    public function model(array $row)
    {
        ++$this->rows;
        $currentRowNumber = $this->getRowNumber();
        
        //  dd($currentRowNumber);
        if (!Webspice::isValidCoordinates($row['latitude'], $row['longitude'])) {
            $this->error .= 'Row ' . $currentRowNumber . ": Invalid coordinates (Latitude, Longitude). <br>";
        } else {
            $areaInfo = Area::where('value', $row['area'])->first();
            if (!$areaInfo) {
                $area = new Area();
                $area->value = $row['area'];
                $area->value_bangla = $row['area'];
                $area->created_by = Auth::user()->id;
                $area->save();
                $areaId = $area->id;
            } else {
                $areaId = $areaInfo->id;
            }

            if ($areaId) {
                # Check Exist
                $marketExist = Market::where('value', $row['market_name_eng'])->where('area_id', $areaId)->where('latitude',$row['latitude'])->where('longitude',$row['longitude'])->first();
                if ($marketExist) {
                    ++$this->alreadyExistRows;
                } else {
                    ++$this->insertedRows;
                    return new Market([
                        'area_id' => $areaId,
                        'value' => $row['market_name_eng'],
                        'value_bangla' => $row['market_name_ban'],
                        'market_address' => $row['market_address'],
                        'latitude' => $row['latitude'],
                        'longitude' => $row['longitude'],
                    ]);
                }
            }
        }
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function getExistingRowCount(): int
    {
        return $this->alreadyExistRows;
    }
    public function getInsertedRowCount(): int
    {
        return $this->insertedRows;
    }
    public function getErrorRow(): string
    {
        return $this->error;
    }
}
