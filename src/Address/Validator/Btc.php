<?php

namespace WalletAddressValidator\Address\Validator;

class Btc extends AbstractBase58
{
    protected $base58PrefixToHexVersion = [
        'prod' => [
            '1' => '00',
            '3' => '05',
        ],
        'testnet' => [
            'm' => '6f',
            '2' => 'c4',
        ],
    ];
}
