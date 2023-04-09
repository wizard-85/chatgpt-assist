<?php

namespace Wizard85\ChatGPTAssist\Console\Commands;

use Illuminate\Console\Command;
use Wizard85\ChatGPTAssist\Services\ChatGPTService;

class GenerateCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat-gpt:make-crud {model} {description=""}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates CRUD by model name and model description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $service = new ChatGPTService();
        $model = $this->argument('model');
        $description = $this->argument('description');
        $this->call('make:model', ['name' =>  $model]);
        $service->makeMigration($model, $description);
        $service->makeController($model, $description);
        $service->makeCreateTemplate($model, $description);
        $service->makeEditTemplate($model, $description);
        $service->makeIndexTemplate($model, $description);

        $this->warn('Remember: code is not final! Please, update it according your project and namespace!');

        return true;
    }
}
