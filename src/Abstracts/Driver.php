<?php

namespace Sinarajabpour1998\Gateway\Abstracts;

use Sinarajabpour1998\Gateway\Contracts\DriverInterface;
use Sinarajabpour1998\Gateway\Traits\DatabaseActions;

abstract class Driver implements DriverInterface
{
    use DatabaseActions;

    public $driver;

    public function __construct($driver)
    {
        $this->driver = $driver;
    }

    abstract public function init($amount, $orderId, $callbackUrl,  $detail = []);

    abstract public function verify($request);

    public function getInformation() {
        return config('gateway.information')[$this->driver]['constructor'];
    }
}
