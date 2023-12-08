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
        // $channel = Log::build([
        //     'driver' => 'single',
        //     'path' => storage_path('logs/ematerai.log'),
        // ]);
           
        
        //Log::info("Cron is working fine!"); 
        $inprogress = Document::select('id')
        ->where('certificatelevel','=','INPROGRESS')
        ->orWhere('certificatelevel','=','FAILUR')->get();
        $arrayId =[];
        foreach($inprogress as $item){
            array_push($arrayId,$item->id);
            //Log::info(['Dociment id :'=> $item->id,$item->source,$channel]);     
            $appsing = SignAdapter::exeSreialStamp([$item->id]);
            Log::info([$arrayId,$appsing]); 
        }
        Log::info([$inprogress]); 
        //Log::stack(['slack', $channel])->info('Something happened!');
       
    }
}
