<?php
require "vendor/autoload.php";
use GuzzleHttp\Client;
class Bot {
    const API_URL = 'https://api.telegram.org/bot';
    private $token = '7880690621:AAHslFJRJV-e99q2reqrEKJ0OVzQfOyyF0c';
    public $client;
    public function makeRequest($method, $data = []) {
        $this->client = new Client([
            'base_uri' => self::API_URL . $this->token,
            'timeout'  => 2.0,
        ]);

        $request = $this->client->request('POST', '/' . $method, ['json' => $data]);

        return json_decode($request->getBody()->getContents());
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, self::API_URL . $this->token . '/' . $method);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        $response = curl_exec($ch);
//        curl_close($ch);
//        return json_decode($response);
    }
}