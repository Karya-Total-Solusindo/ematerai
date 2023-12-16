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
        Log::info('SERVICE STAMP RUN'); 
        $inprogress = Document::select('id')
        ->where('certificatelevel','=','INPROGRESS')
        //->orWhere('certificatelevel','=','NOT_CERTIFIED')
        //->orWhere('certificatelevel','=','FAILUR');
        ->get();
        //Log::debug($inprogress->count());
        $arrayId =[];
        if($inprogress->count() > 0){
            Log::info('START STAMP INPROGRESS'); 
            foreach($inprogress as $item){
                if($item->id != null){
                    array_push($arrayId,$item->id);     
                    $appsign = SignAdapter::exeSreialStamp([$item->id]);
                    Log::info([$arrayId,$appsign]); 
                }
            }
            //Log::info([$inprogress]);
            Log::info('END STAMP INPROGRESS'); 
        }
       
    }
}
