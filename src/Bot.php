<?php

class Bot {

    const API_URL = 'https://api.telegram.org/bot';

    private $token = "7880690621:AAHslFJRJV-e99q2reqrEKJ0OVzQfOyyF0c";

    public function makeRequest($method, $data = []) {
        $this->client = new Client([
            'base_uri' => self::API_URL . $this->token,
            'timeout'  => 2.0,
        ]);
        $response = $this->client->request('GET', '/' . $method);

        return json_decode($response->getBody()->getContents());

//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, self::API_URL . $this->token . '/' .  $method);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        $response = curl_exec($ch);
//        curl_close($ch);
//        var_dump($response);
    }
}
//$bot = new Bot();

