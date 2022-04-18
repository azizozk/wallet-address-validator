<?php

namespace WalletAddressValidator\Address\Asset;

use WalletAddressValidator\Address\AbstractAddress;
use WalletAddressValidator\Address\Network;
use WalletAddressValidator\Address\Validator\Zec as ZecValidator;

class Zec extends AbstractAddress
{
    protected $validators = [
        Network::ZEC => ZecValidator::class,
    ];
}
