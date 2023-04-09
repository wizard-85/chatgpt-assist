<?php

namespace Wizard85\ChatGPTAssist\Providers;

use Illuminate\Support\ServiceProvider;
use Wizard85\ChatGPTAssist\Console\Commands\GenerateCrudCommand;

class ChatGPTProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->offerPublishing();

        $this->commands([
            GenerateCrudCommand::class
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/chatassist.php',
            'chatassist'
        );
    }
    protected function offerPublishing()
    {
        if (! function_exists('config_path')) {
            // function not available and 'publish' not relevant in Lumen
            return;
        }

        $this->publishes([
            __DIR__.'/../../config/chatassist.php' => config_path('chatassist.php'),
        ], 'config');


    }
}
