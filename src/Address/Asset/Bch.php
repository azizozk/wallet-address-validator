<?php

namespace WalletAddressValidator\Address\Asset;

use WalletAddressValidator\Address\AbstractAddress;
use WalletAddressValidator\Address\Network;
use WalletAddressValidator\Address\Validator\Bch as BchValidator;

class Bch extends AbstractAddress
{
    protected $validators = [
        Network::BCH => BchValidator::class,
    ];
}
