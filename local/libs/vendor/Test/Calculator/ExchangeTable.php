<?php


namespace Test\Calculator;


use Bitrix\Main\Entity;

class ExchangeTable extends Entity\DataManager
{
    /**
     * @return string
     */

    public static function getTableName()
    {
        return 'b_exchange';
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
            new Entity\IntegerField('CURRENCY_BASE', [
                'required' => true,
            ]),
            new Entity\IntegerField('CURRENCY_TO', [
                'required' => true,
            ]),
            new Entity\ReferenceField(
                'BASE',
                'CurrencyTable',
                ['=this.CURRENCY_BASE' => 'ref.ID']
            ),
            new Entity\ReferenceField(
                'TO',
                'CurrencyTable',
                ['=this.CURRENCY_TO' => 'ref.ID']
            ),
            new Entity\FloatField('EXCHANGE_VALUE', [
                'required' => true,
                'column_name' => 'EXCHANGE_VALUE',
            ]),
        ];
    }
}
