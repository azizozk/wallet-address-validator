<?php

namespace WalletAddressValidator\Address\Validator;

use WalletAddressValidator\Address\AddressInterface;
use WalletAddressValidator\Address\Validator\Codec\Base32;
use WalletAddressValidator\Address\Validator\Codec\Keccak;

/**
 * https://github.com/QuantumMechanics/NEM-sdk#72---verify-address-validity
 *
 * Class Xem
 * @package WalletAddressValidator\Address\Validator
 */
class Xem implements ValidatorInterface
{
    /** @var string */
    protected $address;

    public function __construct(AddressInterface $address)
    {
        $this->address = $address;
    }

    public function validate(): bool
    {
        // base32 decoded string starts with N, 40 chars, uppercae
        if (preg_match('/^N[ABCDEFGHIJKLMNOPQRSTUVWXYZ234567]{39}$/iu', $this->address) < 1) {
            return false;
        }
        $decoded = Base32::decode($this->address);

        $hex = '';
        foreach (str_split($decoded) as $chr) {
            $hex .= bin2hex($chr);
        }

        $addrCheckSumHex = substr($hex, 42);

        $keccak = Keccak::hash(substr($decoded, 0, 21), 256, false);
        $keccak = substr($keccak, 0, 8);

        return $keccak === $addrCheckSumHex;
    }
}
