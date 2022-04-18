<?php

namespace WalletAddressValidator\Address\Validator;

use WalletAddressValidator\Address\Validator\Codec\Base58;

class Xtz extends AbstractBase58
{
    protected $length = 54;

    protected $base58PrefixToHexVersion = [
        'tz1' => '06A19F',
        'tz2' => '06A1A1',
        'tz3' => '06A1A4',
        'KT' => '025A79',
    ];

    protected function determineVersion($correctAddressTypes): void
    {
        foreach ($correctAddressTypes as $prefix => $hex) {
            if (\strpos($this->address, $prefix) === 0) {
                $this->addressVersion = $hex;
                return;
            }
        }
    }

    public function validate(): bool
    {
        if ($this->addressVersion === null) {
            return false;
        }

        $hexAddress = Base58::base58ToHex(static::$base58Dictionary, $this->address->address());

        if (strlen($hexAddress) !== $this->length) {
            return false;
        }
        $version = substr($hexAddress, 0, 6);

        if (!$this->validateVersion($version)) {
            return false;
        }

        $check = substr($hexAddress, 0, -8);
        $check = pack('H*', $check);
        $check = strtoupper(hash('sha256', hash('sha256', $check, true)));
        $check = substr($check, 0, 8);
        return $check === substr($hexAddress, -8);
    }
}
