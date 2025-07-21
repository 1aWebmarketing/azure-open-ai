<?php
declare(strict_types=1);

namespace AzureOpenAi;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;

final class Client
{
    private GuzzleClient $client;
    private string $deploymentName;
    private string $apiVersion;

    public function __construct(string $endpointUrl, string $apiKey, string $deploymentName, string $apiVersion)
    {
        $this->client = new GuzzleClient([
            'base_uri' => rtrim($endpointUrl, '/') . "/openai/deployments/{$deploymentName}/",
            'headers' => [
                'api-key' => $apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);

        $this->deploymentName = $deploymentName;
        $this->apiVersion = $apiVersion;
    }

    public function chat(array $messages, array $options = []): object
    {
        $body = array_merge([
            'messages' => $messages,
        ], $options);

        try {
            $response = $this->client->post("chat/completions?api-version={$this->apiVersion}", [
                'json' => $body,
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (GuzzleException $e) {
            $obj = new StdClass();
            $obj->error = $e->getMessage();
            return $obj;
        }
    }

    public function image(array $options): object
    {
        try {
            $response = $this->client->post("images/generations?api-version={$this->apiVersion}", [
                'json' => $options,
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (GuzzleException $e) {
            $obj = new StdClass();
            $obj->error = $e->getMessage();
            return $obj;
        }
    }

    public function edits(string $imagePath, string $prompt): object
    {
        try {
            $response = $this->client->post("images/edits?api-version={$this->apiVersion}", [
                'multipart' => [
                    [
                        'name'     => 'image',
                        'contents' => (file_get_contents($imagePath)),
                        'filename' => 'image.png',
                    ],
                    [
                        'name'     => 'prompt',
                        'contents' => $prompt,
                    ],
                ],
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (GuzzleException $e) {
            $obj = new StdClass();
            $obj->error = $e->getMessage();
            return $obj;
        }
    }
}