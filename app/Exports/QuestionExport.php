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
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;



class QuestionExport implements FromArray, WithHeadings, Responsable,  WithStyles,ShouldAutoSize, WithCustomStartCell, WithEvents
{
    use Exportable;
    public $data;
    public $title;
    public function __construct(object $objData, String $title)
    {
        $this->data = $objData->toArray();
        $this->title = $title;
    }

    public function registerEvents(): array
    {
        return  [
            BeforeSheet::class => function (BeforeSheet $event) {
               
                $event->sheet
                    ->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
            },
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:H1'; // All headers
               $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                
            },
        ];
    }
    public function styles(Worksheet $sheet)
    {
        // $sheet->setPageMargin(0);
        // $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', $this->title);
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->mergeCells('A1:H2');
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
                // 'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::HILL_GRADIENT_LINEAR,
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
        $sheet->getStyle('A1:H1')->applyFromArray($styleArray);
        $headerStyleArray = [
            'font' => [
                'bold' => true,
            ]
        ];
        $sheet->getStyle('A3:H3')->applyFromArray($headerStyleArray);
    }
    public function headings(): array
    {
        return [
            [
                "Sl No",
                "Question",
                "Question Bangla",
                "Related To",
                "Relation",
                "Answer Type",
                "Input Type",
                "Is Required"
                // "Info",
                // "Info Bangla",
                // "Sub Info",
                // "Sub Info Bangla",
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
        foreach ($this->data as $k => $val) {
            $relationName = '';
            if($val['related_to']=='question'){
                $relationName = $val['qRelName'];
            }elseif($val['related_to']=='answare'){
                $relationName = $val['aRelName'].'('.$val['aRelNameBangla'].')';
            }
            $customArray[] = array(
                $k + 1,
                $val['question'],
                $val['question_bangla'],
                $val['related_to'],
                $relationName,
                $val['answare_type'],
                $val['input_type'],
                $val['is_required']
                // $val['info'],
                // $val['info_bangla'],
                // $val['sub_info'],
                // $val['sub_info_bangla']
            );
        }
        return $customArray;
    }
}
