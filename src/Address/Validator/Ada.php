<?php

namespace WalletAddressValidator\Address\Validator;

use CBOR\Decoder;
use CBOR\OtherObject;
use CBOR\Tag;
use CBOR\StringStream;
use WalletAddressValidator\Address\Validator\Codec\Base58;

/**
 * @see https://docs.cardano.org/projects/cardano-wallet/en/latest/About-Address-Format---Byron.html
 * @see https://en.wikipedia.org/wiki/CBOR
 *
 * Class Ada
 * @package WalletAddressValidator\Address\Validator
 */
class Ada extends AbstractBase58
{
    public function validate(): bool
    {
        if (trim($this->address) === '') {
            return false;
        }

        $decodedHex = Base58::base58ToHex(self::$base58Dictionary, $this->address);
        $crc = hexdec(substr($decodedHex, -8));

        try {
            $stream = new StringStream(hex2bin($decodedHex));
            $decoder = new Decoder(new Tag\TagObjectManager(), new OtherObject\OtherObjectManager());
            $addrData = $decoder->decode($stream)->getNormalizedData();

            if (($innerCrc = (int) $addrData[1] ?? 0) < 1) {
                return false;
            }

            return $crc === $innerCrc;
        } catch (\Exception $e) {
            return false;
        }
    }
}
