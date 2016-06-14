<?php

namespace Nitrapi\Payment;

use Nitrapi\Nitrapi;

class Order
{
    protected $nitrapi = null;

    public function __construct(Nitrapi &$nitrapi) {
        $this->nitrapi = $nitrapi;
    }

    public function process($rentalTime, array $parts, $imageId, $locationId=2, $type='cloud_server') {
        $price = Price::getPriceStructure($this->nitrapi, $type);
        $this->nitrapi->dataPost("order/order/$type", [
            'price' => $price->getBestPrice($rentalTime, $parts),
            'rental_time' => $rentalTime,
            'parts' => $parts,
            'image_id' => $imageId,
            'location' => $locationId
        ]);
        
        // TODO: Proper errors/success on NitrAPI side
        return true;
    }
}