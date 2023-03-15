<?php

namespace Sabir\ChatGPT;

use Illuminate\Support\ServiceProvider;
use Sabir\ChatGPT\Console\Commands\PublishConfig;

class ChatGPTServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load the package routes
       // $this->registerCommands();
       
        $this->publishes([
            __DIR__ . '/../config/chatgpt.php' => config_path('chatgpt.php'),
        ], 'chatgpt-config');
       // $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ChatGPT::class, function () {
            return new ChatGPT();
        });
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                PublishConfig::class,
            ]);
        }
    }

    protected function configurePublishing()
    {
        if ($this->app->runningInConsole()) {
            
        }
    }
}
