<?php
namespace App\Exports;


use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
// use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

class SurveyReportExport implements FromView, /*WithBackgroundColor, */ShouldAutoSize, WithDrawings, WithEvents
{

    public function __construct(array $data) 
    {
        $this->data = $data;
    }
  public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/img/logo/logo.png'));
        $drawing->setHeight(60);        
        $drawing->setCoordinates('H1');
        // $drawing->setOffsetX(150);
        $drawing->setOffsetY(5);
        return $drawing;
    }
    public function view(): View
    {        
        return view('report.salary_statement_export', [
            'report_format' => $this->data['report_format'],
            'vat_rate' => $this->data['vat_rate'],
            'tax_rate' => $this->data['tax_rate'],
            'payment_deduction_info' => $this->data['payment_deduction_info'],
            'salary_statements' => $this->data['salary_statements']
        ]);
    }
    use RegistersEventListeners;

    public static function afterSheet(AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();

        // $sheet->getStyle('1')->getFont()->setSize(16);
        $sheet->getStyle('A1:O2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF');
        // ...
    }
    
    // public function backgroundColor()
    // {
    //     // Return RGB color code.
    //     // return '000000';
    
    //     // Return a Color instance. The fill type will automatically be set to "solid"
    // //    return new Color(Color::COLOR_YELLOW);
    
    //     // Or return the styles array
    //     // return [
    //     //      'fillType'   => Fill::FILL_GRADIENT_LINEAR,
    //     //      'startColor' => ['argb' => Color::COLOR_CYAN],
    //     // ];
    // }
}