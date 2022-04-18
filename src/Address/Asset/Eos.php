<?php

namespace WalletAddressValidator\Address\Asset;

use WalletAddressValidator\Address\AbstractAddress;
use WalletAddressValidator\Address\Network;
use WalletAddressValidator\Address\Validator\Eos as EosValidator;

class Eos extends AbstractAddress
{
    protected $validators = [
        Network::EOS => EosValidator::class,
    ];
}
