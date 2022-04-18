<?php

namespace WalletAddressValidator\Address\Asset;

use WalletAddressValidator\Address\AbstractAddress;
use WalletAddressValidator\Address\Network;
use WalletAddressValidator\Address\Validator\Dash as DashValidator;

class Dash extends AbstractAddress
{
    protected $validators = [
        Network::DASH => DashValidator::class,
    ];
}
