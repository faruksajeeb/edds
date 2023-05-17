<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;


class UserResponseExport implements FromArray, WithHeadings, Responsable, ShouldAutoSize, WithStyles, WithCustomStartCell
{
    use Exportable;
    public $data;
    public $title;
    public function __construct(object $objData,String $title)
    {
        ini_set('max_execution_time', 30*60); // 30 min
        ini_set('memory_limit', '2048M');
        $this->data = $objData->toArray();
        $this->title =$title;
    }
    public function styles(Worksheet $sheet)
    {
        // $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $this->title);
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->mergeCells('A1:F2');
        $styleArray = [
            'font' => [
                'bold' => true,
                'size' => 20,
                'color' => array('rgb' => 'FFFFFF'),
            ],
            'alignment' => [
                // 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            // 'borders' => [
            //     'outline' => [
            //         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            //         'color' => ['argb' => '000000'],
            //     ],
            // ],
            'fill' => [
                // 'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FFA0A0A0',
                ],
                'endColor' => [
                    'argb' => 'FFFFFFFF',
                ],
            ],
        ];
        $sheet->getStyle('A1:F1')->applyFromArray($styleArray);
        $headerStyleArray = [
            'font' => [
                'bold' => true,
            ]];
        $sheet->getStyle('A3:F3')->applyFromArray($headerStyleArray);
    }
    public function headings(): array
    {
        return [
            [
                "Sl No",
                "Resonse Date",
                "Full Name",
                "Email",
                "Mobile",
                "Respondent"
            ]
        ];
    }
    public function startCell(): string
    {
        return 'A3';
    }
    public function array(): array
    {
        $customArray = array();
        foreach ($this->data as $k=>$val) {
            $customArray[] = array(
                $k+1,
                Date::dateTimeToExcel($val['response_date']),
                isset($val['registered_user']['full_name']) ? $val['registered_user']['full_name'] : '',
                isset($val['registered_user']['email']) ? $val['registered_user']['email'] : '',
                isset($val['registered_user']['mobile_no']) ? $val['registered_user']['mobile_no'] : '',
                isset($val['registered_user']['respondent_type']) ? $val['registered_user']['respondent_type'] : ''
            );
        }
        return $customArray;
    }
}

