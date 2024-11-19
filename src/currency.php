<?php

require_once 'vendor/autoload.php';
use GuzzleHttp\Client;
class  Currency{

    const CURRENCY_API_URL = "https://cbu.uz/uz/arkhiv-kursov-valyut/json/";
    public $client;
    public array $currencies = [];
    public function __construct(){
        
        $ch = curl_init();
            $this->client = new Client([
                'base_uri' => self::CURRENCY_API_URL,
                'timeout' => 2.0,
            ]);
    }

    public function getCurrencies() : array {
        $separeted_data = [];
        $currencies_info = $this->currencies;
        foreach($currencies_info as $currency) {
            $separeted_data[$currency->Ccy] = $currency->Rate;

        }
        return $separeted_data;

    }

    public function exchange($value, $currency_name='USD') {

        echo ceil($value / $this->getCurrencies()[$currency_name]) . ' currency.php' . $currency_name;

    }
}