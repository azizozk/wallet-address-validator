<?php

namespace WalletAddressValidator\Address\Validator;

use WalletAddressValidator\Address\AddressInterface;
use WalletAddressValidator\Address\Validator\Codec\Base58;
use WalletAddressValidator\Address\Validator\Codec\Keccak;

/**
 * Class Xmr
 * @package WalletAddressValidator\Address\Validator
 * @see https://monero.fandom.com/wiki/Address_validation
 */
class Xmr implements ValidatorInterface
{
    protected static $base58Dictionary = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';

    protected $base58PrefixToHexVersion = [
        '4' => '12'
    ];

    // const FULL_BLOCK_SIZE = 8;
    const FULL_ENCODED_BLOCK_SIZE = 11;
    const  SECOND_CHARS = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'A', 'B'];
    const NETWORKS = [
        18, 42, // prod
        53, // testnet
    ];

    protected static $encodedBlockSizes = [0, 2, 3, 5, 6, 7, 9, 10, 11];

    protected $patterns = [
        '/^[123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz]{95}$/',
        '/^[123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz]{106}$/'
    ];

    /** @var AddressInterface */
    protected $address;

    /** @var string|null  */
    protected $paymentId;


    public function __construct(AddressInterface $address)
    {
        $this->address = $address;
        $this->paymentId = $address->getParam('memo');
    }

    public function validate(): bool
    {
        // format
        if ($this->isFormatValid() === false) {
            return false;
        }

        // memo
        if ($this->paymentId !== null && (!ctype_xdigit($this->paymentId) || strlen($this->paymentId) !== 64)) {
            return false;
        }

        // see documentation
        if (! in_array($this->address->address()[1], self::SECOND_CHARS)) {
            return false;
        }

        $address = $this->address->address();
        $addressIntArr = $this->strtoIntArr($address);
        $addLen = count($addressIntArr);
        $fullBlockCount = floor($addLen / self::FULL_ENCODED_BLOCK_SIZE);
        $lastBlockSize = $addLen % self::FULL_ENCODED_BLOCK_SIZE;
        $lastBlockDecodedSize =  self::$encodedBlockSizes[$lastBlockSize] ?? false;
        if ($lastBlockDecodedSize === false) {
            // malformed address structure
            return false;
        }

        // decoded address dec arr
        $parts = [];

        // decode 8 -> 11 base58
        for ($i = 0; $i < $fullBlockCount; $i++) {
            $offset = $i * self::FULL_ENCODED_BLOCK_SIZE;
            $addressPart = substr($address, $offset, self::FULL_ENCODED_BLOCK_SIZE);
            $decoded = Base58::base58ToIntArr(self::$base58Dictionary, $addressPart);
            $parts = array_merge($parts, $decoded);
        }

        if ($lastBlockSize > 0) {
            $offset = $fullBlockCount * self::FULL_ENCODED_BLOCK_SIZE;
            $addressPart = substr($address, $offset, $lastBlockSize);
            $decoded = Base58::base58ToIntArr(self::$base58Dictionary, $addressPart);
            if ($decoded[0] === 0) { // extra zero in dict
                unset($decoded[0]);
            }
            $parts = array_merge($parts, $decoded);
        }

        // validate network
        if (! in_array($parts[0], self::NETWORKS)) {
            return false;
        }

        $decodedHex = '';
        foreach ($parts as $dec) {
            $hex = dechex($dec);
            $decodedHex .= strlen($hex) < 2 ? "0$hex" : $hex;
        }

        $addrCheckSum = substr($decodedHex,-8);
        $addrData = array_map(function ($hex) {
            return hex2bin($hex);
        }, str_split(substr($decodedHex, 0, -8), 2));

        $keccak = Keccak::hash(implode('', $addrData), 256, false);
        return $addrCheckSum === substr($keccak, 0, 8);
    }

    private function isFormatValid(): bool
    {
        foreach ($this->patterns as $pattern) {
            if (preg_match($pattern, $this->address->address()) > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $str
     * @return int[]
     */
    private function strtoIntArr(string $str): array
    {
        return array_map(function ($char) {
            return ord($char);
        }, str_split($str));
    }
}
