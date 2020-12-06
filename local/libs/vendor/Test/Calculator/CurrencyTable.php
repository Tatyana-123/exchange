<?php


namespace Test\Calculator;


use Bitrix\Main\Entity;

class CurrencyTable extends Entity\DataManager
{
    /**
     * @return string
     */

    public static function getTableName()
    {
        return 'b_currency';
    }

    /**
     * @return array
     */
    public static function getMap()
    {
        return [
            new Entity\IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true,
                'column_name' => 'ID',
            ]),
            new Entity\StringField('CURRENCY_NAME', [
                'required' => true,
                'column_name' => 'CURRENCY_NAME',
            ]),
            new Entity\StringField('CURRENCY_SIGN', [
                'required' => true,
                'column_name' => 'CURRENCY_SIGN',
            ]),
        ];
    }
}
