<?php

namespace WalletAddressValidator\Address\Validator;

use WalletAddressValidator\Address\Validator\Codec\Base58;

class Xrp extends AbstractBase58
{
    protected static $base58Dictionary = 'rpshnaf39wBUDNEGHJKLM4PQRST7VWXYZ2bcdeCg65jkm8oFqi1tuvAxyz';

    public function validate(): bool
    {
        if (preg_match('/^r[' . self::$base58Dictionary . ']{27,35}$/', $this->address) < 1) {
            return false;
        }

        $hexAddress = Base58::base58ToHex(self::$base58Dictionary, $this->address->address());
        $check = substr($hexAddress, 0, strlen($hexAddress) - 8);
        $check = pack('H*', $check);
        $check = strtoupper(hash('sha256', hash('sha256', $check, true)));
        $check = substr($check, 0, 8);
        return $check === substr($hexAddress, strlen($hexAddress) - 8);
    }
}
