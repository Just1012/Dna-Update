<?php
namespace App\Rules;

use App\Models\orderDayes;
use Illuminate\Contracts\Validation\Rule;

class UniqueOrderDay implements Rule
{
    protected $orderId;
    protected $addressId;

    public function __construct($orderId, $addressId)
    {
        $this->orderId = $orderId;
        $this->addressId = $addressId;
    }

    public function passes($attribute, $value)
    {
        return !orderDayes::where('order_id', $this->orderId)
                          ->where('address_id', $this->addressId)
                          ->where('day', $value)
                          ->exists();
    }

    public function message()
    {
        return 'The combination of order, address, and day must be unique.';
    }
}

