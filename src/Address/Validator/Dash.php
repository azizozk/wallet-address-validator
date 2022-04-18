<?php

namespace WalletAddressValidator\Address\Validator;

class Dash extends AbstractBase58
{
    const VERSION_P2PKH = '4C';
    const VERSION_P2SH = '10';

    protected $base58PrefixToHexVersion = [
        'prod' => [
            'X' => self::VERSION_P2PKH,
            '7' => self::VERSION_P2SH
        ],
        'testnet' => [
            'y' => '8c',
            '8' => '13',
        ]
    ];
}
