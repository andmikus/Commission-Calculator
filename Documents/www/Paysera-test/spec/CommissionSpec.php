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

    function it_should_limit_min_commission()
    {
        $this->limitMinAmount('cash_out', 'juridical', 0.3, 'EUR')->shouldBeLike(0.5);
    }

    function it_should_limit_max_commission()
    {
        $this->limitMaxAmount('cash_in', 'natural', 10, 'EUR')->shouldBeLike( 5);
    }

}
