<?php

namespace Sabir\ChatGPT;

use GuzzleHttp\Client;

class ChatGPT
{
    protected $apiKey;
    protected $baseUrl;
    protected $client;
    protected $model;


    public function __construct()
    {

        $this->baseUrl = 'https://api.openai.com/v1/';
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . config('chatgpt.api_key'),
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function get($endpoint)
    {
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }

    public function post($endpoint, $data)
    {
        $response = $this->client->post($endpoint, [
            'json' => $data,
        ]);
        return json_decode($response->getBody()->getContents());
    }

    public function Chat($message, $type = 'davinci', $options = [])
    {
        $model = config('chatgpt.model');

        switch ($type) {
            case 'chat':
                $url = 'chat/completions';
                $data = [
                    'model' => $model,
                    'prompt' => $message,
                    'temperature' => $options['temperature'] ?? 0.5,
                    'max_tokens' => $options['max_tokens'] ?? 60,
                    'top_p' => $options['top_p'] ?? 1,
                    'frequency_penalty' => $options['frequency_penalty'] ?? 0,
                    'presence_penalty' => $options['presence_penalty'] ?? 0,
                    'stop' => $options['stop'] ?? null,
                    'n' => $options['n'] ?? 1,
                    'stream' => $options['stream'] ?? false,
                    'logprobs' => $options['logprobs'] ?? null,
                    'echo' => $options['echo'] ?? false,
                    'messages' => [
                        [
                            'type' => 'text',
                            'text' => $message,
                        ]
                    ],
                ];
                break;

            case 'davinci':
            case 'curie':
            case 'babbage':
            case 'ada':
                $url = 'completions';
                $data = [
                    'model' => $model, // This should be changed to the appropriate model ID for the chosen API type
                    'prompt' => $message,
                    'temperature' => $options['temperature'] ?? 0.5,
                    'max_tokens' => $options['max_tokens'] ?? 60,
                    'top_p' => $options['top_p'] ?? 1,
                    'frequency_penalty' => $options['frequency_penalty'] ?? 0,
                    'presence_penalty' => $options['presence_penalty'] ?? 0,
                    'stop' => $options['stop'] ?? null,
                    'n' => $options['n'] ?? 1,
                    'stream' => $options['stream'] ?? false,
                    'logprobs' => $options['logprobs'] ?? null,
                    'echo' => $options['echo'] ?? false,
                ];
                break;

                // Other cases...

            default:
                throw new Exception("Unsupported API type: $type");
        }

        $response = $this->post($url, $data);
        return $response;
    }




    // Add additional methods as needed
}
