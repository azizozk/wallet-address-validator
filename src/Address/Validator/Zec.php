<?php

namespace WalletAddressValidator\Address\Validator;

class Zec extends AbstractBase58
{
    protected $base58PrefixToHexVersion = [
        't' => '1C',
        'z' => '16',
    ];

    protected $lengths = [
        't' => 52,
        'z' => 140
    ];
}
