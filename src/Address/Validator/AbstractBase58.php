<?php

namespace WalletAddressValidator\Address\Validator;

use WalletAddressValidator\Address\AddressInterface;
use WalletAddressValidator\Address\Validator\Codec\Base58;

abstract class AbstractBase58 implements ValidatorInterface
{
    protected static $base58Dictionary = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';

    /** @var AddressInterface */
    protected $address;
    protected $addressVersion;

    protected $base58PrefixToHexVersion = [
        'prod' => [],
        'testnet' => [],
    ];
    protected $length = 50;
    protected $lengths = [];

    public function __construct(AddressInterface $address)
    {
        $this->address = $address;
        $versions = $this->base58PrefixToHexVersion['prod'] ?? $this->base58PrefixToHexVersion;
        $this->determineVersion($versions);
    }

    public function validate(): bool
    {
        if (trim($this->address) === '') {
            return false;
        }
        if ($this->addressVersion === null) {
            return false;
        }

        $hexAddress = Base58::base58ToHex(static::$base58Dictionary, $this->address->address());
        $length = $this->length;

        if (!empty($this->lengths[$this->address->address()[0]])) {
            $length = $this->lengths[$this->address->address()[0]];
        }

        if (strlen($hexAddress) !== $length) {
            return false;
        }

        $version = substr($hexAddress, 0, 2);

        if (!$this->validateVersion($version)) {
            return false;
        }

        $check = substr($hexAddress, 0, strlen($hexAddress) - 8);
        $check = pack("H*", $check);
        $check = strtoupper(hash("sha256", hash("sha256", $check, true)));
        $check = substr($check, 0, 8);

        return $check == substr($hexAddress, strlen($hexAddress) - 8);
    }

    protected function validateVersion($version): bool
    {
        return hexdec($version) === hexdec($this->addressVersion);
    }

    protected function determineVersion($correctAddressTypes): void
    {
        $verChar = $this->address->address()[0] ?? '';
        if (isset($correctAddressTypes[$verChar])) {
            $this->addressVersion = $correctAddressTypes[$verChar];
        }
    }

    // redundant
    // protected function hash160ToAddress($hash160): string
    // {
    //     $hash160 = $this->addressVersion.$hash160;
    //     $check = pack("H*", $hash160);
    //     $check = hash("sha256", hash("sha256", $check, true));
    //     $check = substr($check, 0, 8);
    //     $hash160 = strtoupper($hash160.$check);
    //
    //     if (strlen($hash160) % 2 != 0) {
    //         $this->addressVersion = null;
    //     }
    //
    //     return Base58::encodeBase58(self::$base58Dictionary, $hash160);
    // }
    //
    // protected function pubKeyToAddress($pubkey): string
    // {
    //     return $this->hash160ToAddress(self::hash160($pubkey));
    // }
    //
    // protected static function hash160($data): string
    // {
    //     $data = pack("H*", $data);
    //     return strtoupper(hash("ripemd160", hash("sha256", $data, true)));
    // }
    //
    // protected static function addressToHash160($addr): string
    // {
    //     $addr = Base58::base58ToHex(static::$base58Dictionary, $addr);
    //     $addr = substr($addr, 2, strlen($addr) - 10);
    //     return $addr;
    // }
}
