<?php

namespace WalletAddressValidator\Address\Asset;

use WalletAddressValidator\Address\AbstractAddress;
use WalletAddressValidator\Address\Network;
use WalletAddressValidator\Address\Validator\TRC20 as TrxValidator;

class Btt extends AbstractAddress
{
    protected $networkAlias = [
        self::BTT => Network::TRC20,
        self::TRX => Network::TRC20,
    ];

    protected $validators = [
        Network::TRC20 => TrxValidator::class,
    ];
}
