<?php

namespace App\Exports;

use App\Models\Document;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;



class ExportDocumentSuccess implements  FromCollection, WithHeadings
{

    use Exportable;
    public function collection()
    {
    //    self::headings();
        return Document::where('document.certificatelevel', 'CERTIFIED')
        ->join('companies','companies.id','company_id')
        ->join('directories','directories.id','=','directory_id')
        ->get(['document.id','filename','companies.name as company','directories.name as directories','certificatelevel','directories.created_at']);
        
    }
    public function headings(): array
    {
        return [
            'NO', //ambil nomor
            'DOCUMENT',
            'COMPANY',
            'DIRECTORY',
            'Status',
            'STEMP',
            'Date',
        ];
    }


}
