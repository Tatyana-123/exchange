<?php


namespace Test\Calculator;


class Calculate
{
    private $currencyBase;
    private $currencyTo;
    private $sum;

    public function __construct(string $currencyBase, string $currencyTo, string $sum)
    {
        $this->currencyBase = $currencyBase;
        $this->currencyTo = $currencyTo;
        $this->sum = $sum;
    }

    public function getBaseExchangeData()
    {
        $res = ExchangeTable::getList([
            'select' => ['EXCHANGE_VALUE'],
            'filter' => [
                '=CURRENCY_BASE' => $this->currencyBase,
                '=CURRENCY_TO' => $this->currencyTo,
            ],
        ])->fetch();

        return $res['EXCHANGE_VALUE'] ?? 0;
    }

    public function getResExchangeData($baseExchangeValue)
    {
        return $baseExchangeValue * $this->sum;
    }

    public function getCacheString()
    {
        return serialize($this->currencyBase . $this->currencyTo);
    }

    /**
     * @return array
     */

    public function getInputData()
    {
        return [
            'currencyBase' => $this->currencyBase,
            'currencyTo' => $this->currencyTo,
            'sum' => $this->sum,
        ];
    }

}