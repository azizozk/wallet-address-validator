<?php

namespace WalletAddressValidator\Address\Asset;

use WalletAddressValidator\Address\AbstractAddress;
use WalletAddressValidator\Address\Network;
use WalletAddressValidator\Address\Validator\TRC20 as TrxValidator;

class Trx extends AbstractAddress
{
    protected $networkAlias = [
        self::TRX => Network::TRC20,
    ];

    protected $validators = [
        Network::TRC20 => TrxValidator::class,
    ];
}
