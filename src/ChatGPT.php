<?php

namespace Sabir\ChatGPT;

use GuzzleHttp\Client;

class ChatGPT
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . config('chatgpt.api_key'),
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function request($method, $endpoint, $data = [])
    {
        $response = $this->client->request($method, $endpoint, [
            'json' => $data,
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function chat($message, $type = 'davinci', $options = [])
    {
        $model = config('chatgpt.model');
        $url = ($type === 'chat') ? 'chat/completions' : 'completions';

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
        ];

        if ($type === 'chat') {
            $data['messages'] = [
                [
                    'type' => 'text',
                    'text' => $message,
                ],
            ];
        }

        return $this->request('POST', $url, $data);
    }

    // Add additional methods as needed
}
