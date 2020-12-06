<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$APPLICATION->IncludeComponent(
    "test:calc",
    ".default",
    array(
        "CACHE_TIME" => "86400",
        "CACHE_TYPE" => "A",
    ),
    false
);
