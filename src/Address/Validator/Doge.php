<?php

namespace WalletAddressValidator\Address\Validator;

class Doge extends AbstractBase58
{
    protected $base58PrefixToHexVersion = [
        'D' => '1E',
        '9' => '16',
        'A' => '16',
    ];
}
