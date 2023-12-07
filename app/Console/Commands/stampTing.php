<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Adapter\SignAdapter;
use App\Models\Company;
use App\Models\Directory;
use App\Models\Document;

class stampTing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:stamp-ting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command untuk jalankan prosess stempting';

    /**
     * Execute the console command.
     */
    public function handle()
    { 
        //Log::info("Cron is working fine!"); 
        $inprogress = Document::select('id')
        ->where('certificatelevel','=','INPROGRESS')
        ->orWhere('certificatelevel','=','FAILUR')->get();
        $arrayId =[];
        foreach($inprogress as $item){
            array_push($arrayId,$item->id);
            Log::info('Dociment id :'.$item->id.' '.$item->source);     
            $appsing = SignAdapter::exeSreialStamp([$item->id]);
            Log::info($appsing); 
            Log::info($arrayId); 
        }
        Log::info($inprogress); 
       
    }
}
