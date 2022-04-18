<?php

namespace WalletAddressValidator\Address\Asset;

use WalletAddressValidator\Address\AbstractAddress;
use WalletAddressValidator\Address\Network;
use WalletAddressValidator\Address\Validator\ERC20 as EthValidator;
use WalletAddressValidator\Address\Validator\OMNI as UsdtValidator;
use WalletAddressValidator\Address\Validator\TRC20 as TrxValidator;

class Usdt extends AbstractAddress
{
    protected $networkAlias = [
        self::USDT => Network::OMNI,
        self::ETH => Network::ERC20,
        self::TRX => Network::TRC20,
    ];

    protected $validators = [
        Network::ERC20 => EthValidator::class,
        Network::OMNI => UsdtValidator::class,
        Network::TRC20 => TrxValidator::class
    ];
}
