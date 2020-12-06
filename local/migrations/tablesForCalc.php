<?php
if (empty($_SERVER["DOCUMENT_ROOT"])) {
    $_SERVER['DOCUMENT_ROOT'] = str_replace("/test", '', realpath(dirname(__FILE__)));
}

require($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php');

use Test\Calculator\CurrencyTable;
use Test\Calculator\ExchangeTable;
use Bitrix\Main\Application;
use Bitrix\Main\Entity\Base;


$dbApps = Application::getConnection();

$base = Base::getInstance(CurrencyTable::class);

$tableName = $base->getDBTableName();

if(!$dbApps->isTableExists($tableName)) {
    $base->createDbTable($tableName);
}

$arrayOfData = [
    [
        'CURRENCY_NAME' => 'RUR',
        'CURRENCY_SIGN' => '₽'
    ],
    [
        'CURRENCY_NAME' => 'USD',
        'CURRENCY_SIGN' => '$'
    ],
    [
        'CURRENCY_NAME' => 'EUR',
        'CURRENCY_SIGN' => '€'
    ],

];
foreach ($arrayOfData as $item) {
    CurrencyTable::add($item);
}
$baseExchange = Base::getInstance(ExchangeTable::class);

$tableNameExchange = $baseExchange->getDBTableName();
if(!$dbApps->isTableExists($tableNameExchange)) {
    $baseExchange->createDbTable($tableNameExchange);
}
$arrayOfDataExchange = [
    [
        'CURRENCY_BASE' => 1,
        'EXCHANGE_VALUE' => 0.013,
        'CURRENCY_TO' => 2,
    ],
    [
        'CURRENCY_BASE' => 1,
        'EXCHANGE_VALUE' => 0.011,
        'CURRENCY_TO' => 3,
    ],
    [
        'CURRENCY_BASE' => 2,
        'EXCHANGE_VALUE' => 76.46,
        'CURRENCY_TO' => 1,
    ],
    [
        'CURRENCY_BASE' => 2,
        'EXCHANGE_VALUE' => 0.84,
        'CURRENCY_TO' => 3,
    ],
    [
        'CURRENCY_BASE' => 3,
        'EXCHANGE_VALUE' => 91.17,
        'CURRENCY_TO' => 1,
    ],
    [
        'CURRENCY_BASE' => 3,
        'EXCHANGE_VALUE' => 1.19,
        'CURRENCY_TO' => 2,
    ],

];

foreach ($arrayOfDataExchange as $itemExchange) {
       ExchangeTable::add($itemExchange);
}