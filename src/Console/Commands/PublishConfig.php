<?php

namespace Laravel\Sail\Console;

use Illuminate\Console\Command;

class  PublishConfig  extends  Command
{

    //    here the config files of ChatGPT will be published

    /* 
    *   The name and signature of the console command.
    *   @var string
    */

    protected $signature  =  'sabir:chatgpt';

    protected $description  =  'Publish the ChatGPT config files';

    public function  handle()
    {
        $this->call('vendor:publish', ['--tag'  =>  'chatgpt-config']);
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/chatgpt.php'  =>  config_path('chatgpt.php'),
        ],  'chatgpt-config');
    }

    
}
