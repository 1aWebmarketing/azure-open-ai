<?php

require '../vendor/autoload.php';

use AzureOpenAi\Client;

$client = new Client(
    'https://your-resource.openai.azure.com',   // Your Azure OpenAI endpoint
    'your-api-key-here',                            // Your API key
    'your-deployment-name',                 // Your deployment name
    '2025-01-01-preview'                         // API version
);

try {
    $response = $client->chat([
        ['role' => 'user', 'content' => 'Hello from Azure!'],
        ['role' => 'user', 'content' => 'My secret value is 42'],
        ['role' => 'user', 'content' => 'What is my secret value?'],
    ]);

    print_r($response->choices[0]->message->content);
} catch (Exception $e) {
    echo $e->getMessage();
}
