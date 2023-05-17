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
        $drawing->setPath(public_path('/logo.png'));
        $drawing->setHeight(60);        
        $drawing->setCoordinates('A1');
        // $drawing->setOffsetX(150);
        $drawing->setOffsetY(5);
        return $drawing;
    }
    public function view(): View
    {  if($this->data['report_type']=='question_wise'){
            $view = 'report.question_wise_survey_report_export';
        }else if($this->data['report_type']=='sub_question_wise'){
            $view = 'report.survey_report_export';
        }
        return view($view, [
            'report_format' => $this->data['report_format'],
            'division' => $this->data['division'],
            'district' => $this->data['district'],
            'thana' => $this->data['thana'],
            'date_from' => $this->data['date_from'],
            'date_to' => $this->data['date_to'],
            'records' => $this->data['records']
        ]);
    }
    use RegistersEventListeners;

    public static function afterSheet(AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();

        // $sheet->getStyle('1')->getFont()->setSize(16);
        $sheet->getStyle('A1:H2')->getFill()
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