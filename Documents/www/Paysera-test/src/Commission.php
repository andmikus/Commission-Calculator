<?php namespace App;

use OutOfBoundsException;

/**
 * Class Commission
 *
 * @package App
 */
class Commission {

    /**
     *  Limit commission fee amount by minimum
     *
     * @param $operationType
     * @param $customer
     * @param $amount
     * @param $currency
     * @return float
     */
    static function limitMinAmount($operationType, $customer, $amount, $currency)
    {
        try {

            $minCommissionFee = config($customer, $operationType . ':min');
            if ($minCommissionFee > 0 && $minCommissionFee > Operation::toGeneralCurrency($amount, $currency)) {

                return Operation::toOperationCurrency($minCommissionFee, $currency);
            }
        } catch(OutOfBoundsException $e) {}

        return $amount;
    }

    /**
     * Limit commission fee amount by maximum
     *
     * @param $operationType
     * @param $customer
     * @param $amount
     * @param $currency
     * @return float
     */
    static function limitMaxAmount($operationType, $customer, $amount, $currency)
    {
        try {

            $maxCommissionFee = config($customer, $operationType . ':max');
            if ($maxCommissionFee > 0 && $maxCommissionFee < Operation::toGeneralCurrency($amount, $currency)) {

                return Operation::toOperationCurrency($maxCommissionFee, $currency);
            }
        } catch(OutOfBoundsException $e) {}

        return $amount;
    }

    /**
     * Calculate commission for given operation
     *
     * @param $operationType
     * @param $customer
     * @param $operationAmount
     * @param $currency
     * @return float|string
     */
    static function getCommissionFee($operationType, $customer, $operationAmount, $currency)
    {
        try {

            $commissionRate = config($customer, $operationType);
            $commissionAmount = $operationAmount * $commissionRate / 100;

            $commissionAmount = self::limitMinAmount($operationType, $customer, $commissionAmount, $currency);
            $commissionAmount = self::limitMaxAmount($operationType, $customer, $commissionAmount, $currency);

            return $commissionAmount;

        } catch(OutOfBoundsException $e) {

            return "Commission rate for given operation not found!";
        }
    }



}
