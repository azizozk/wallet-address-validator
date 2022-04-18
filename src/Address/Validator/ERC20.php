<?php

namespace WalletAddressValidator\Address\Validator;

use WalletAddressValidator\Address\AddressInterface;
use WalletAddressValidator\Address\Validator\Codec\Keccak;

class ERC20 implements ValidatorInterface
{
    /** @var AddressInterface */
    protected $address;

    public function __construct(AddressInterface $address)
    {
        $this->address = $address;
    }

    public function validate(): bool
    {
        if ($this->isPatternMatch() === false) {
            return false;
        }

        if ($this->isCaseMatch()) {
            return true;
        }

        return $this->verifyChecksum();
    }


    protected function isPatternMatch(): bool
    {
        return preg_match('/^(0x)?[0-9a-f]{40}$/i', $this->address->address()) > 0;
    }

    protected function isCaseMatch(): bool
    {
        $address = ltrim($this->address->address(), 'x0');
        return strtolower($address) === $address || strtoupper($address) === $address;
    }

    protected function verifyChecksum(): bool
    {
        $address = ltrim($this->address->address(), 'x0');
        $hash = Keccak::hash(strtolower($address), 256);

        // See: https://github.com/web3j/web3j/pull/134/files#diff-db8702981afff54d3de6a913f13b7be4R42
        for ($i = 0; $i < 40; $i++) {
            if (ctype_alpha($address[$i])) {
                // Each uppercase letter should correlate with a first bit of 1 in the hash char with the same index,
                // and each lowercase letter with a 0 bit.
                $charInt = intval($hash[$i], 16);

                if ((ctype_upper($address[$i]) && $charInt <= 7) || (ctype_lower($address[$i]) && $charInt > 7)) {
                    return false;
                }
            }
        }

        return true;
    }
}
