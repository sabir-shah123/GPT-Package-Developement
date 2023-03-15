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

    public function Chat($message)
    {
        $messages = [
            [
                'role' => 'user',
                'content' => $message,
            ],
        ];
        $data = [
            'model' => config('chatgpt.model'),
            'messages' => $messages,
        ];
        return $this->post('chat/completions', $data);
    }




    // Add additional methods as needed
}
