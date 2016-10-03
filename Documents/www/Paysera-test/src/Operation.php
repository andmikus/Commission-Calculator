<?php namespace App;

use Carbon\Carbon;
use OutOfBoundsException;

/**
 * Class Operation
 *
 * @package App
 */
class Operation {

    /**
     * Aggregate operations data: amount and operations count by week
     *
     * @param $operationData
     * @param $aggregatedData
     * @return array
     */
    public static function aggregateData($operationData, $aggregatedData)
    {
        $operationDate = Carbon::createFromFormat('Y-m-d', $operationData['transaction_date']);
        if ( ! empty($aggregatedData)
            && $aggregatedData['year'] == $operationDate->year
            && $aggregatedData['week'] == $operationDate->weekOfYear) {

            $aggregatedData['aggregateAmount'] += self::toGeneralCurrency($operationData['operation_amount'], $operationData['currency']);
            $aggregatedData['aggregateCount'] += 1;

            return $aggregatedData;
        }

        $aggregatedData = array(
            'year'  =>  $operationDate->year,
            'week'  =>  $operationDate->weekOfYear,
            'aggregateAmount' => self::toGeneralCurrency($operationData['operation_amount'], $operationData['currency']),
            'aggregateCount' => 1
        );

        return $aggregatedData;
    }

    /**
     * Return operation amount for commission calculation
     *
     * @param $aggregatedData
     * @param $operationData
     * @param $amountLimit
     * @param $countLimit
     * @return float|int
     */
    public static function limitPeriodAmount($aggregatedData, $operationData, $amountLimit, $countLimit)
    {
        if ($aggregatedData['aggregateCount'] > $countLimit) {
            return $operationData['operation_amount'];
        }

        $odds = $aggregatedData['aggregateAmount'] - $amountLimit;

        if ($odds < 0) {
            return 0;
        }

        if ($odds > self::toGeneralCurrency($operationData['operation_amount'], $operationData['currency'])) {
            return $operationData['operation_amount'];
        }

        return self::toOperationCurrency($odds, $operationData['currency']);
    }

    /**
     * Exchange given amount to general currency
     *
     * @param $amount
     * @param $currency
     * @return float
     */
    public static function toGeneralCurrency($amount, $currency)
    {
        try {
            return round($amount / config('exchange_rates', $currency), 4);
        } catch (OutOfBoundsException $e) {
            return $amount;
        }
    }

    /**
     * Exchange given amount in general currency to operation currency
     *
     * @param $amount
     * @param $currency
     * @return float
     */
    public static function toOperationCurrency($amount, $currency)
    {
        try {
            return round($amount * config('exchange_rates', $currency), 4);
        } catch (OutOfBoundsException $e) {
            return $amount;
        }
    }

}