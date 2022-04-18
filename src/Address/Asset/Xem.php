<?php

namespace WalletAddressValidator\Address\Asset;

use WalletAddressValidator\Address\AbstractAddress;
use WalletAddressValidator\Address\Network;
use WalletAddressValidator\Address\Validator\Xem as XemValidator;

class Xem extends AbstractAddress
{
    protected $validators = [
        Network::XEM => XemValidator::class,
    ];
}
