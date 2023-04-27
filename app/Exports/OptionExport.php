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

class OptionExport implements FromArray, WithHeadings, Responsable, ShouldAutoSize, WithStyles, WithCustomStartCell
{
    use Exportable;
    public $data;
    public function __construct(object $objData)
    {
        $this->data = $objData->toArray();
    }
    public function styles(Worksheet $sheet)
    {
        // $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Option List');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->mergeCells('A1:I2');
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
        $sheet->getStyle('A1:I1')->applyFromArray($styleArray);
        $headerStyleArray = [
            'font' => [
                'bold' => true,
            ]];
        $sheet->getStyle('A3:I3')->applyFromArray($headerStyleArray);
    }
    public function headings(): array
    {
        return [
            [
                "Sl No",
                "Option Group Name",
                "Option Value",
                "Option Value2",
                "Option Value3",
                "Created At",
                "Updated At",
                "Created By",
                "Updated By"
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
                str_replace('_',' ',$val['option_group_name']),
                $val['option_value'],
                $val['option_value2'],
                $val['option_value3'],
                $val['created_at'],
                $val['updated_at'],
                $val['created_by'],
                $val['updated_by'],
            );
        }
        return $customArray;
    }
}

