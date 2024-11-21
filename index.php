
<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//
//
//
//require 'resources/views/currency-converter.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//var_dump($uri);

if ($uri == '/weather') {
    require "resources/views/weather.php";
}elseif ($uri == '/currency'){
    require 'src/currency.php';
    $currency = new Currency();
    require "resources/views/currency-converter.php";
}elseif ($uri == '/telegram'){
        require 'app/bot.php';
}else{
    echo 404;
}