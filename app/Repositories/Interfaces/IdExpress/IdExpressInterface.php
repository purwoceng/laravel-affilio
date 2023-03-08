<?php

namespace App\Repositories\Interfaces\IdExpress;

interface IdExpressInterface
{
    function createOrder($data);
    function trackBill(string $data);
}
