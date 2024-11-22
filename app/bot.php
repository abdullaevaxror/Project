<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require 'src/Bot.php';
require 'src/currency.php';
require 'src/Weather.php';

$bot = new Bot();
$currency = new Currency();
$weather = new Weather();

$update = json_decode(file_get_contents('php://input'));
var_dump($update);

if (isset($update)) {
    $text = $update->message->text;
    $from_id = $update->message->from->id;
    $username = $update->message->from->username;
    if ($text == '/start') {
        $response = $bot->makeRequest('sendMessage', [
            'chat_id' => $from_id,
            'text'=>"Hello World! <a href='https://core.telegram.org/bots/api#message'>dcndsjcjsd</a>",
            'parse_mode' => 'html'
        ]);
        $bot->saveUser($from_id, $username);
        if (!$response->ok) {
            $bot->makeRequest('sendMessage', [
                'chat_id' => $from_id,
                'text'=>json_encode($response),
            ]);
        }
    }

    if ($text == '/weather'){
        $weather2 = $weather->getWeather();
        $temperatura = $weather2->main->temp - 273.15;
        $pressure = $weather2->main->pressure;
        $humidity = $weather2->main->humidity;

        $bot->makeRequest('sendMessage', [
            'chat_id' => $from_id,
            'text' => "Weather in Tashkent\n\nTemperature: " . round($temperatura, 2) . " °C\n\n" .
            "Pressure: " . $pressure . " hPa\n\n" .
            "Humidity: " . $humidity . "%\n\n"

        ]);
    }

    if ($text == '/currency') {
        $currencies = $currency->getCurrencies();

        $currency_list = "";
        foreach ($currencies as $currency => $rate) {
            $currency_list .= $currency . ": " . $rate . "\n";
        }
        $bot->makeRequest('sendMessage', [
            'chat_id' => $from_id,
            'text' => $currency_list,
        ]);

    }
}