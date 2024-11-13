<?php
require "currency.php";

$currency = new Currency();

$currencies = $currency->getCurrencies();

require "currency-converter.php";
