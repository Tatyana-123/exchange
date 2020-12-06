<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Test\Calculator\CurrencyTable;
use Test\Calculator\Calculate;

class Calc extends CBitrixComponent
{

    /**
     * @param array $arParams
     * @return array
     */

    public function onPrepareComponentParams($arParams): array
    {
        $result = [
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => isset($arParams["CACHE_TIME"]) ? $arParams["CACHE_TIME"] : 36000000,
        ];
        return $result;
    }

    /**
     * @return array
     */

    public function executeComponent(): array
    {
        try {
            $calculator = null;
            $data = $this->getPostData();

            if ($this->checkData($data)) {
                $calculator = new Calculate($data['currencyBase'], $data['currencyTo'], $data['sum']);
                $cacheId = $calculator->getCacheString();
            } else {
                $cacheId = '';
            }

            $obCache = new CPHPCache();
            if ($obCache->InitCache(false, $cacheId)) {
                $currencyLib = $obCache->GetVars();
            } elseif ($obCache->StartDataCache()) {
                $currencyLib['currencyLib'] = $this->getAvailableCurrency();
                if ($calculator instanceof Calculate) {
                    $currencyLib['baseExchange'] = $calculator->getBaseExchangeData();
                }
                $obCache->EndDataCache($currencyLib);
            }

            $this->arResult = $currencyLib;
            $this->arResult['inputData'] = $data;
            if (!empty($this->arResult['baseExchange'])) {
                if (is_null($calculator)) {
                    $calculator = new Calculate(
                        $this->arResult['inputData']['currencyBase'],
                        $this->arResult['inputData']['currencyTo'],
                        $this->arResult['inputData']['sum']);
                }
                $this->arResult['resExchange'] = $calculator->getResExchangeData($this->arResult['baseExchange']);
            }
            $this->includeComponentTemplate();

        } catch (Exception $e) {
            $this->abortResultCache();
            $this->arResult = [];
        }
        return $this->arResult;
    }

    private function getPostData()
    {
        return \Bitrix\Main\Application::getInstance()->getContext()->getRequest()->getPostList()->toArray();
    }

    /**
     * @return array
     */

    private function getAvailableCurrency(): array
    {
        $availableCurrency = [];

        $availableCurrencies = CurrencyTable::getList([
            'select' => ['*'],
        ]);
        while ($res = $availableCurrencies->fetch()) {
            $availableCurrency[$res['ID']] = $res;
        }
        return $availableCurrency;
    }

    /**
     * @param array $data
     * @return bool
     */
    private function checkData(array $data): bool
    {
        if (
            empty($data['currencyBase']) ||
            empty($data['currencyTo']) ||
            empty($data['sum'])
        ) {
            return false;
        }
        return true;
    }

}