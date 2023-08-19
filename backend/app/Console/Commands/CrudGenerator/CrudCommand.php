<?php

namespace App\Console\Commands\CrudGenerator;

use App\Console\Commands\CrudGenerator\Template\ControllerMold;
use App\Console\Commands\CrudGenerator\Template\HttpMold;
use App\Console\Commands\CrudGenerator\Template\ModelMold;
use App\Console\Commands\CrudGenerator\Template\ViewMold;
use Illuminate\Console\Command;

class CrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     *  protected $signature = 'do:
    {crud:generate CRU$tableD}
    {api:generate API}
    {model:generate model}
    {controller:generate controller}
    {view:gerar generate view blade}
    ';
     * @var string
     */
    protected $signature = 'do {type} {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->argument('type');
        $type = str_replace(':','',$type);
        $table = $this->argument('table');

        if($type=='model'){
            if(ModelMold::buildModel($table)){
                echo "Generated Model ☑️ ".PHP_EOL;
            }else{
                echo "Houve um problema de execução verifique no Log";
            }
        }
        elseif($type=='controller'){
            if( ControllerMold::buildController($table)){
                echo "Generated Controller ☑️ ".PHP_EOL;
            }else{
                echo "Houve um problema de execução verifique no Log";
            }

        }
        elseif($type=='http'){
            if( HttpMold::buildHttp($table)){
                echo "Generated HTTP teste ☑️ ".PHP_EOL;
            }else{
                echo "Houve um problema de execução verifique no Log";
            }

        }
        elseif($type=='view'){
            ViewMold::buildView($table);
        }else{
            echo "Comand not found";
        }

    }
}
