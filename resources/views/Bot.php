<?php

class Bot {

    const API_URL = 'https://api.telegram.org/bot';

    private $token = "7880690621:AAHslFJRJV-e99q2reqrEKJ0OVzQfOyyF0c";

    public function makeRequest($method, $data = []) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::API_URL . $this->token . '/' .  $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        curl_close($ch);
        var_dump($response);
    }
}
$bot = new Bot();
$bot->makeRequest('sendMessage', [
    'chat_id'=>6222424607,
    'text'=>'Hello World'
]);
$bot->makeRequest('sendVideo', [
   'chat_id'=>6222424607,
   'video'=>'https://www.w3schools.com/html/mov_bbb.mp4'
]);
$json = file_get_contents('https://cbu.uz/uz/arkhiv-kursov-valyut/json/');
$data = json_decode($json, true);

//s Valyuta kurslari haqida xabar tayyorlash
$message = "Valyuta kurslari:\n";
foreach ($data as $valyuta) {
    $message .= $valyuta['CcyNm_UZ'] . ": " . $valyuta['Rate'] . " so'm\n";
}

?>