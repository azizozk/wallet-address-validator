<?php

namespace WalletAddressValidator\Address\Validator;

use WalletAddressValidator\Address\AddressInterface;
use WalletAddressValidator\Address\Validator\Codec\Base58;

class TRC20 implements ValidatorInterface
{
    protected $base58Dictionary = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';

    protected $lenght = 34;

    protected $lenghtBinary = 25;

    protected $versionsHex = [
        'prod' => '41',
        // 'testnet' => 'A0'
    ];

    /** @var AddressInterface */
    protected $address;

    public function __construct(AddressInterface $address)
    {
        $this->address = $address;
    }

    public function validate(): bool
    {
        if (strlen($this->address) !== $this->lenght) {
            return false;
        }

        $decodedHex = Base58::base58ToHex($this->base58Dictionary, $this->address->address());
        if ($this->versionsHex['prod'] !== substr($decodedHex, 0, 2)) {
            return false;
        }
        $decodedBin = hex2bin($decodedHex);

        if (strlen($decodedBin) !== $this->lenghtBinary) {
            return false;
        }

        $addrCheckSum = substr($decodedBin, 21);
        $addrBody = substr($decodedBin, 0, 21);

        $hash = hash('sha256', $addrBody, true);
        $hash = hash('sha256', $hash, true);
        $checkSum = substr($hash, 0, 4);

        return $checkSum === $addrCheckSum;
    }
}
