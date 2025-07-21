# Azure OpenAI PHP Client

A simple PHP wrapper class to use OpenAI with Microsoft Azure.

## Installation

```bash
composer require oneawebmarketing/azure-open-ai
```

## Requirements

- PHP 7.4 or higher
- Guzzle HTTP Client 7.9 or higher

## Quick Start

```php
<?php

require 'vendor/autoload.php';

use AzureOpenAi\Client;

// Initialize the client
$client = new Client(
    'https://your-resource.openai.azure.com',  // Your Azure OpenAI endpoint
    'your-api-key-here',                       // Your API key
    'your-deployment-name',                    // Your deployment name
    '2025-01-01-preview'                       // API version
);

// Send a chat message
$response = $client->chat([
    ['role' => 'user', 'content' => 'Hello, how are you?']
]);

// Access the response
echo $response->choices[0]->message->content;
```

## Usage Examples

### Basic Chat Completion

```php
$response = $client->chat([
    ['role' => 'user', 'content' => 'What is the capital of France?']
]);

echo $response->choices[0]->message->content;
```

### Conversation with Multiple Messages

```php
$response = $client->chat([
    ['role' => 'system', 'content' => 'You are a helpful assistant.'],
    ['role' => 'user', 'content' => 'What is the capital of France?'],
    ['role' => 'assistant', 'content' => 'The capital of France is Paris.'],
    ['role' => 'user', 'content' => 'Tell me more about it.']
]);
```

### With Custom Options

```php
$response = $client->chat([
    ['role' => 'user', 'content' => 'Write a short story.']
], [
    'max_tokens' => 150,
    'temperature' => 0.7,
    'top_p' => 0.9
]);
```

### Image generation

```php
$response = $client->image([
     'prompt' => 'Create an image of a squirrel looking into the camera i can use as avatar'
 ]);

file_put_contents('output.png', base64_decode($response->data[0]->b64_json));
```

## Error Handling

The client returns a standard object. In case of errors, the response will contain an `error` property:

```php
$response = $client->chat([...]);

if (isset($response->error)) {
    echo "Error: " . $response->error;
} else {
    echo $response->choices[0]->message->content;
}
```

## Configuration

### Azure OpenAI Setup

1. Create an Azure OpenAI resource in the Azure portal
2. Deploy a model (e.g., GPT-4, GPT-3.5-turbo)
3. Get your endpoint URL, API key, and deployment name
4. Use these values when initializing the client

### Environment Variables (Recommended)

For security, store your credentials in environment variables:

1. Create a `.env` file in your project root:
   ```env
   AZURE_OPENAI_ENDPOINT=https://your-resource.openai.azure.com
   AZURE_OPENAI_API_KEY=your-actual-api-key
   AZURE_OPENAI_DEPLOYMENT=your-deployment-name
   AZURE_OPENAI_API_VERSION=2025-01-01-preview
   ```

2. Load environment variables in your code:
   ```php
   $client = new Client(
       $_ENV['AZURE_OPENAI_ENDPOINT'],
       $_ENV['AZURE_OPENAI_API_KEY'],
       $_ENV['AZURE_OPENAI_DEPLOYMENT'],
       $_ENV['AZURE_OPENAI_API_VERSION']
   );
   ```

3. Add `.env` to your `.gitignore`:
   ```
   .env
   .env.local
   .env.*.local
   ```

## API Reference

### Constructor

```php
new Client(string $endpointUrl, string $apiKey, string $deploymentName, string $apiVersion)
```

**Parameters:**
- `$endpointUrl` - Your Azure OpenAI endpoint URL
- `$apiKey` - Your Azure OpenAI API key
- `$deploymentName` - Your deployment name
- `$apiVersion` - API version (e.g., '2025-01-01-preview')

### Chat Method

```php
chat(array $messages, array $options = []): object
```

**Parameters:**
- `$messages` - Array of message objects with 'role' and 'content'
- `$options` - Optional parameters like max_tokens, temperature, etc.

**Returns:** Object containing the API response

## Testing

Run the included example:

```bash
php examples/chat.php
```

Make sure to update the credentials in the example file with your actual Azure OpenAI credentials.

## License

This package is licensed under the BSD-2-Clause license.

## Support

For issues and questions, please visit: https://github.com/1awebmarketing/azure-open-ai 