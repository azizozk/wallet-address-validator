<?php

namespace WalletAddressValidator\Address\Asset;

use WalletAddressValidator\Address\AbstractAddress;
use WalletAddressValidator\Address\Network;
use WalletAddressValidator\Address\Validator\Ltc as LtcValidator;

class Ltc extends AbstractAddress
{
    protected $validators = [
        Network::LTC => LtcValidator::class,
    ];
}
