<?php

namespace WalletAddressValidator\Address\Asset;

use WalletAddressValidator\Address\AbstractAddress;
use WalletAddressValidator\Address\Network;
use WalletAddressValidator\Address\Validator\Btg as BtgValidator;

class Btg extends AbstractAddress
{
    protected $validators = [
        Network::BTG => BtgValidator::class,
    ];
}
