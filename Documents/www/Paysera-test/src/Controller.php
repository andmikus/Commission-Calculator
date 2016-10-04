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
        //Get input type from config.ini
        $inputType = config('input_type');

        //Load class of the input type (file)
        $className = 'App\\' . ucfirst($inputType);
        $input = new $className();

        //Load data from input
        $data = new Data($input, $dataSource);
        $dataMatrix = $data->dataMatrix();

        foreach ($dataMatrix as $operationData) {

            //Identify customer by Id
            $currentCustomer = $operationData[config('identifier')];

            //Initialize aggregation array for current customer
            isset($aggregatedData[$currentCustomer]) ?: $aggregatedData[$currentCustomer] = [];

            try {
                //Get aggregation period for current customer type and operation type
                //Todo: create universal function for using this parameter
                if ($period = config($operationData['customer_type'], $operationData['operation_type'].':period')) {

                    //Get operation amount limit for aggregation
                    $amountLimit = config($operationData['customer_type'], $operationData['operation_type'] . ':period_max');
                    //Get operation count limit for aggregation
                    $countLimit = config($operationData['customer_type'], $operationData['operation_type'] . ':period_count');

                    //Add data tu aggregation array
                    $aggregatedData[$currentCustomer] = Operation::aggregateData($operationData, $aggregatedData[$currentCustomer]);

                    //Filter operation amount by business logic
                    $operationData['operation_amount'] = Operation::limitPeriodAmount(
                        $aggregatedData[$currentCustomer],
                        $operationData,
                        $amountLimit,
                        $countLimit
                    );
                }
            //Catch 'No aggregation data period set in config' error
            } catch(OutOfBoundsException $e) {}

            //Calculate commission fee for current operation
            $commissionFee = Commission::getCommissionFee(
                $operationData['operation_type'],
                $operationData['customer_type'],
                $operationData['operation_amount'],
                $operationData['currency']);

            echo roundUp($commissionFee, 2) . "\n";
        }
    }
}