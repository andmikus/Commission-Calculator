<?php

namespace spec\App;

use App\Commission;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommissionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Commission::class);
    }

    function it_should_return_min_commission()
    {
        $this->limitAmount('cash_in', 'natural', 10)->shouldReturn(10);
    }

}
