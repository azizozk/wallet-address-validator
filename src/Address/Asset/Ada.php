<?php

namespace WalletAddressValidator\Address\Asset;

use WalletAddressValidator\Address\AbstractAddress;
use WalletAddressValidator\Address\Network;
use WalletAddressValidator\Address\Validator\Ada as AdaValidator;

class Ada extends AbstractAddress
{
    protected $validators = [
        Network::ADA => AdaValidator::class,
    ];
}
