<?php namespace App;

use OutOfBoundsException;

/**
 * Class Controller
 *
 * @package App
 */
class Controller {

    /**
     * General application processing function
     *
     * @param $dataSource
     */
    function execute($dataSource)
    {
        $inputType = config('input_type');
        $className = 'App\\' . ucfirst($inputType);
        $input = new $className();
        $data = new Data($input, $dataSource);

        $dataMatrix = $data->dataMatrix();
        foreach ($dataMatrix as $operationData) {

            $currentCustomer = $operationData[config('identifier')];
            isset($aggregatedData[$currentCustomer]) ?: $aggregatedData[$currentCustomer] = [];

            try {
                $period = config($operationData['customer_type'], $operationData['operation_type'].':period');
                $amountLimit = config($operationData['customer_type'], $operationData['operation_type'] . ':period_max');
                $countLimit = config($operationData['customer_type'], $operationData['operation_type'] . ':period_count');


                $aggregatedData[$currentCustomer] = Operation::aggregateData($operationData, $aggregatedData[$currentCustomer]);

//                var_dump($aggregatedData[$currentCustomer]);
                $operationData['operation_amount'] = Operation::limitPeriodAmount(
                    $aggregatedData[$currentCustomer],
                    $operationData,
                    $amountLimit,
                    $countLimit
                );


            } catch(OutOfBoundsException $e) {}

            $commissionFee = Commission::getCommissionFee(
                $operationData['operation_type'],
                $operationData['customer_type'],
                $operationData['operation_amount'],
                $operationData['currency']);

            echo "\n" . roundUp($commissionFee, 2);
        }
    }
}