<?php

namespace WalletAddressValidator\Address\Asset;

use WalletAddressValidator\Address\AbstractAddress;
use WalletAddressValidator\Address\Network;
use WalletAddressValidator\Address\Validator\Doge as DogeValidator;

class Doge extends AbstractAddress
{
    protected $validators = [
        Network::DOGE => DogeValidator::class,
    ];
}
