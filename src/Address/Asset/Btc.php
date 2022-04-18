<?php

namespace WalletAddressValidator\Address\Asset;

use WalletAddressValidator\Address\AbstractAddress;
use WalletAddressValidator\Address\Network;
use \WalletAddressValidator\Address\Validator\Btc as BtcValidator;

class Btc extends AbstractAddress
{
    protected $validators = [
        Network::BTC => BtcValidator::class
    ];
}
