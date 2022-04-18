<?php

namespace WalletAddressValidator\Address\Validator;

use WalletAddressValidator\Address\AddressInterface;
use WalletAddressValidator\Address\Validator\Codec\Base32;

class Xlm implements ValidatorInterface
{
    const VERSION_BYTES = [
        'ed25519PublicKey' =>  6 << 3, // G
        'ed25519SecretSeed' => 18 << 3, // S
        'preAuthTx' => 19 << 3, // T
        'sha256Hash' => 23 << 3  // X
    ];

    /** @var AddressInterface */
    protected $address;

    /** @var string */
    protected $memo;

    public function __construct(AddressInterface $address)
    {
        $this->address = $address->address();
        $this->memo = $address->getParam('memo');
    }

    public function validate(): bool
    {
        if (preg_match('/^[A-Z2-7]{56}$/', $this->address) < 1) {
            return false;
        }

        if ($this->memo !== null && strlen($this->memo) > 28) {
            return false;
        }

        $decoded = Base32::decode($this->address);
        $versionByte = ord($decoded[0]);
        $payload = substr($decoded, 0, -2);
        $decodedData = substr($payload, 1);
        $checksum = substr($decoded, -2);

        if (self::VERSION_BYTES['ed25519PublicKey'] !== $versionByte) {
            return false;
        }

        if (strlen($decodedData) !== 32) {
            return false;
        }

        if ($this->crc16Pack($payload) !== $checksum) {
            return false;
        }

        return true;
    }

    protected function crc16Pack($binaryString)
    {
        $crc = 0x0000;
        $polynomial = 0x1021;
        foreach (str_split($binaryString) as $byte) {
            $byte = ord($byte);
            for ($i = 0; $i < 8; $i++) {
                $bit = (($byte >> (7 - $i) & 1) === 1);
                $c15 = (($crc >> 15 & 1) === 1);
                $crc <<= 1;
                if ($c15 ^ $bit) {
                    $crc ^= $polynomial;
                }
            }
        }
        return pack('v', $crc & 0xffff);
    }
}
