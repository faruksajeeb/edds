<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class AreaExport implements FromArray, WithHeadings, Responsable, ShouldAutoSize, WithStyles, WithCustomStartCell
{
    use Exportable;
    public $data;
    public $title;
    public function __construct(object $objData,String $title)
    {
        $this->data = $objData->toArray();
        $this->title =$title;
    }
    public function styles(Worksheet $sheet)
    {
        // $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $this->title);
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->mergeCells('A1:K2');
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
                // 'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::KILL_GRADIENT_LINEAR,
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
        $sheet->getStyle('A1:K1')->applyFromArray($styleArray);
        $headerStyleArray = [
            'font' => [
                'bold' => true,
            ]];
        $sheet->getStyle('A3:K3')->applyFromArray($headerStyleArray);
    }
    public function headings(): array
    {
        return [
            [
                "Sl No",
                "Division",
                "District",
                "Thana",
                "Area Name In English",
                "Area Name In Bangla",
                "Latitude",
                "Longitude",
                "Status",
                "Created At",
                "Updated At",
                // "Created By",
                // "Updated By"
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
                $val['division'],
                $val['district'],
                $val['thana'],
                $val['value'],
                $val['value_bangla'],
                $val['latitude'],
                $val['longitude'],
                ($val['status']==1)?'Active':'Inactive',
                $val['created_at'],
                $val['updated_at'],
                // $val['created_by'],
                // $val['updated_by'],
            );
        }
        return $customArray;
    }
}

