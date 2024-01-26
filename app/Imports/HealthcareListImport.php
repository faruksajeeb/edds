<?php
namespace App\Imports;

use App\Lib\Webspice;
use App\Models\Healthcare;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithValidation;

use App\Rules\EnglishCharacters;
use App\Rules\BanglaCharacters;

class HealthcareListImport implements ToModel, WithBatchInserts, WithChunkReading, WithValidation, WithHeadingRow
{
    use RemembersRowNumber;
    private $rows = 0;
    private $insertedRows = 0;
    private $alreadyExistRows = 0;
    private $error = '';

    public function rules(): array
    {
        return [
            'type' => [
                'string',
                'required',
                'in:human,animal',
            ],
            'hospital_name_english' => [
                'required',
                'string',
                new EnglishCharacters
            ],
            'hospital_name_bangla' => [
                'required',
                'string',
                new BanglaCharacters
            ],
            'latitude' => ['required', 'numeric',
                'min:-90', 'max:90',
            ],
            'longitude' => ['required', 'numeric',
                'min:-180', 'max:180',
            ],
            'address' => [

            ]
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
                # Check Exist
                $centerExist = Healthcare::where('hospital_name_english', $row['hospital_name_english'])->where('type', $row['type'])->where(['latitude'=>$row['latitude'],'longitude'=>$row['longitude']])->first();
                if ($centerExist) {
                    ++$this->alreadyExistRows;
                } else {
                    ++$this->insertedRows;
                    return new Healthcare([
                        'type' => $row['type'],
                        'hospital_name_english' => $row['hospital_name_english'],
                        'hospital_name_bangla' => $row['hospital_name_bangla'],
                        'address' => $row['address'],
                        'latitude' => $row['latitude'],
                        'longitude' => $row['longitude'],
                    ]);
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
