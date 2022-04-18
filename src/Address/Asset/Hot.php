<?php

namespace WalletAddressValidator\Address\Asset;

use WalletAddressValidator\Address\AbstractAddress;
use WalletAddressValidator\Address\Network;
use WalletAddressValidator\Address\Validator\ERC20 as EthValidator;

class Hot extends AbstractAddress
{
    protected $networkAlias = [
        self::HOT => Network::ERC20,
        self::ETH => Network::ERC20
    ];

    protected $validators = [
        Network::ERC20 => EthValidator::class,
    ];
}
