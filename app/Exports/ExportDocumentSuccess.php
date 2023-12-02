<?php

namespace App\Exports;

use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithProperties;



class ExportDocumentSuccess implements WithProperties, FromQuery, ShouldAutoSize, WithMapping, WithCustomStartCell, WithColumnFormatting, WithHeadings, WithDrawings, WithColumnWidths
{

    use Exportable;
    public $status;
    public $year;
    public $month;
    public $day;
    protected $table_data;
 
    public function __construct(array $status, int $year =null, int $month=null, int $day=null)
    {  
        $this->status = $status;
        $this->month = $month;
        $this->day = $day;
    }

    public function properties(): array
    {
        return [
            'title'          => 'E-materai Export '.$this->status['certificatelevel'],
            'category'       => $this->status['certificatelevel'],
        ];
    }

    public function array(): array
    {
        return [
            $this->table_data
        ];
    }

    public function query()
    {
        $user = Auth::user()->id;
        return Document::query()->where($this->status)->whereUser_id($user);
        // return Document::query()->wherecertificatelevel($this->status);
    }
    public function map($table_data): array
    {
        $document = $table_data; //(empty($table_data['filename'])) ? 'Cast' : $table_data['department']['name'];
        if($document->certificatelevel=='FAILUR'){
            return [      
                '=ROW()-7',
                Date::dateTimeToExcel($document['created_at']),
                $document->certificatelevel,
                $document->filename,     
                $document->message,
                $document->company->name,
                $document->directory->name,
                $document->sn,
            ];
        }else{
            return [      
                '=ROW()-7',
                Date::dateTimeToExcel($document['created_at']),
                $document->certificatelevel,
                $document->filename,     
                $document->company->name,
                $document->directory->name,
                $document->sn,
            ];
        }
    }
    


    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            // 'C' => NumberFormat::FORMAT_CURRENCY_EUR_INTEGER,
        ];
    }
    public function columnWidths(): array
    {
        return [
            // 'D' => 55,                       
            // 'D' => 45,            
            // 'E' => 18,            
            // 'F' => 45,            
            // 'G' => 45,            
            // 'H' => 15,            
        ];
    }
    public function startCell(): string
    {
        // START FROM writing data 
        return 'A7';
    }
    public function headings(): array
    {
        if($this->status['certificatelevel']=='FAILUR'){
            return [
                'NO', //ambil nomor
                'DATE',
                'STATUS',
                'DOCUMENT',
                'FAILURE',
                'COMPANY',
                'DIRECTORY',
                'SN',
            ];
        }else{
            return [
                'NO', //ambil nomor
                'DATE',
                'STATUS',
                'DOCUMENT',
                'COMPANY',
                'DIRECTORY',
                'SN',
            ];
        }
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Rafpoint Logo');
        $drawing->setPath(public_path('/img/fp-logo.png'));
        $drawing->setHeight(30);
        $drawing->setCoordinates('A1');
        return $drawing;
    }




}
