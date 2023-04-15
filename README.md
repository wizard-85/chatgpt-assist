## Installation
- `composer require wizard85/chatgpt-assist`
- To publish config: `php artisan vendor:publish --provider="SWizard85\ChatGPTAssist\Providers\ChatGPTProvider"`

## ENV Variables
- CHAT_GPT_TOKEN=
- CHAT_GPT_MAX_TORENS=4000
- CHAT_GPT_VERSION=text-davinci-003

## Usage

`php artisan chat-gpt:make-crud "Model Name" "Model description"`

- **Example:** php artisan chat-gpt:make-crud "Test" "title(string), description, is_active"


## Api Calls
Create New Service Instance: 

`$service = new ChatGPTService();`

Request New Description for Product:

`$service->makeProductDescription('Lenovo Q27q-20', 'en');`

Make Free Call to Chat GPT

`$service->makeCall('Description for Lenovo Q27q-20');`
