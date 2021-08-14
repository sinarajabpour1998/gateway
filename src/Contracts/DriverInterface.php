<?php

namespace Sinarajabpour1998\Gateway\Contracts;

interface DriverInterface
{
    public function init($amount, $orderId, $callbackUrl, $detail = []);

    public function verify($request);
}
