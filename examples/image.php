<?php

require 'vendor/autoload.php';

use AzureOpenAi\Client;

$client = new Client(
    'https://your-resource.openai.azure.com',   // Your Azure OpenAI endpoint
    'your-api-key-here',                            // Your API key
    'your-deployment-name',                 // Your deployment name
    '2025-01-01-preview'                         // API version
);

try {
    $response = $client->image([
        'prompt' => 'Create an image of a squirrel looking into the camera i can use as avatar'
    ]);

    file_put_contents('output.png', base64_decode($response->data[0]->b64_json));

    echo "fertig";
} catch (Exception $e) {
    echo $e->getMessage();
}