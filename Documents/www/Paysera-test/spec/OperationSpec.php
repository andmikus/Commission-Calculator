<?php

namespace spec\App;

use App\Operation;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OperationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Operation::class);
    }

    function it_return_currency_general()
    {
        $this->toGeneralCurrency(100, 'EUR')->shouldReturn(100);
    }

    function it_exchange_to_currency_general()
    {
        $this->toGeneralCurrency(100, 'JPY')->shouldReturn(0.772);
    }
}
