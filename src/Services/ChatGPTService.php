<?php

namespace Wizard85\ChatGPTAssist\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Wizard85\ChatGPTAssist\Exceptions\ChatGPTNotAvailableException;

class ChatGPTService
{
    protected string $key;
    protected int $maxTokens;
    protected string $version;
    protected string $url;

    public function __construct()
    {
        $this->key = config('chatassist.key');
        $this->maxTokens = config('chatassist.max_tokens');
        $this->version = config('chatassist.version');
        $this->url =  config('chatassist.url');
    }

    static function checkFolder(string $folder):void
    {
        if(!is_dir($folder)){
            mkdir($folder);
        }
    }

    public function makeCall(string $string): ?string
    {
        $data = [
            "model" => $this->version,
            "prompt" => $string,
            "temperature" => 0,
            "max_tokens" => $this->maxTokens
        ];

        $response = Http::acceptJson()
            ->timeout(120)
            ->asJson()
            ->withHeaders([
                'authorization' => 'Bearer '.$this->key
            ])
            ->post($this->url, $data)
            ->json();

        if(isset($response['choices'][0]['text'])) {
            return $response['choices'][0]['text'];
        }

        throw new ChatGPTNotAvailableException();
    }

    final public function makeMigration(string $model, string $description): ?string
    {
        $requestString = 'Give me Laravel migration code for model '.$model.' with fields '.$description .'.';
        $fileData = $this->makeCall($requestString);
        $timestamp = date('Y_m_d_His');
        $fileName = $timestamp.'_create_for_model_'.Str::lower($model).'_table.php';
        self::checkFolder(base_path('database/migrations'));
        $myfile = fopen(base_path('database/migrations/'.$fileName), "w") or die("Unable to open file!");
        fwrite($myfile, '<?php'.PHP_EOL.$fileData);
        fclose($myfile);

        return base_path('database/migrations/'.$fileName);
    }

    final public function makeController(string $model, string $description): ?string
    {
        $requestString = 'Give me Laravel CRUD Controller code for model '.$model.' with fields '.$description .'.';
        $fileData = $this->makeCall($requestString);
        $fileName = $model.'Controller.php';
        self::checkFolder(base_path(config('chatassist.locations.controllers')));
        $myfile = fopen(base_path(config('chatassist.locations.controllers').$fileName), "w") or die("Unable to open file!");
        fwrite($myfile, $fileData);
        fclose($myfile);

        return base_path(config('chatassist.locations.controllers').$fileName);
    }

    final public function makeCreateTemplate(string $model, string $description): ?string
    {
        $requestString = 'Give me Laravel Create Blade template for model '.$model.' with fields '.$description .'.';
        $fileData = $this->makeCall($requestString);
        $fileName = 'create.blade.php';
        self::checkFolder(base_path(config('chatassist.locations.views').Str::lower(Str::plural($model))));
        $myfile = fopen(base_path(config('chatassist.locations.views').Str::lower(Str::plural($model)).'/'.$fileName), "w") or die("Unable to open file!");
        fwrite($myfile, $fileData);
        fclose($myfile);

        return base_path(config('chatassist.locations.views').Str::lower(Str::plural($model)).'/'.$fileName);
    }

    final public function makeEditTemplate(string $model, string $description): ?string
    {
        $requestString = 'Give me Laravel Edit Blade template for model '.$model.' with fields '.$description .'.';
        $fileData = $this->makeCall($requestString);
        $fileName = 'edit.blade.php';
        self::checkFolder(base_path(config('chatassist.locations.views').Str::lower(Str::plural($model))));
        $myfile = fopen(base_path(config('chatassist.locations.views').Str::lower(Str::plural($model)).'/'.$fileName), "w") or die("Unable to open file!");
        fwrite($myfile, $fileData);
        fclose($myfile);

        return base_path(config('chatassist.locations.views').Str::lower(Str::plural($model)).'/'.$fileName);
    }

    final public function makeIndexTemplate(string $model, string $description): ?string
    {
        $requestString = 'Give me Laravel Index Blade template for model '.$model.' with fields '.$description .'.';
        $fileData = $this->makeCall($requestString);
        $fileName = 'index.blade.php';
        self::checkFolder(base_path(config('chatassist.locations.views').Str::lower(Str::plural($model))));
        $myfile = fopen(base_path(config('chatassist.locations.views').Str::lower(Str::plural($model)).'/'.$fileName), "w") or die("Unable to open file!");
        fwrite($myfile, $fileData);
        fclose($myfile);

        return base_path(config('chatassist.locations.views').Str::lower(Str::plural($model)).'/'.$fileName);
    }

    final public function makeProductDescription(string $product,string $locale = 'en'): ?string
    {
        $requestString = str_replace('::product', $product, config('chatassist.product_description_request.'.$locale));
        $fileData = $this->makeCall($requestString);
        return $fileData;
    }
}
