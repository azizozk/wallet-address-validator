<?php

namespace WalletAddressValidator\Address\Asset;

use WalletAddressValidator\Address\AbstractAddress;
use WalletAddressValidator\Address\Network;
use WalletAddressValidator\Address\Validator\Xrp as XrpValidator;

class Xrp extends AbstractAddress
{
    protected $validators = [
        Network::XRP => XrpValidator::class,
    ];
}
