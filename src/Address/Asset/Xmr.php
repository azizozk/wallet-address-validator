<?php

namespace WalletAddressValidator\Address\Asset;

use WalletAddressValidator\Address\AbstractAddress;
use WalletAddressValidator\Address\Network;
use WalletAddressValidator\Address\Validator\Xmr as XmrValidator;

class Xmr extends AbstractAddress
{
    protected $validators = [
        Network::XMR => XmrValidator::class,
    ];
}
