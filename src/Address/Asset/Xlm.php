<?php

namespace WalletAddressValidator\Address\Asset;

use WalletAddressValidator\Address\AbstractAddress;
use WalletAddressValidator\Address\Network;
use WalletAddressValidator\Address\Validator\Xlm as XlmValidator;

class Xlm extends AbstractAddress
{
    protected $validators = [
        Network::XLM => XlmValidator::class,
    ];
}
