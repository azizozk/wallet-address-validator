<?php

namespace WalletAddressValidator\Address\Validator\Codec;

class Base58
{
    public static function decodeHex(string $hex): string
    {
        $hex = strtoupper($hex);
        $chars = "0123456789ABCDEF";
        $return = "0";
        for ($i = 0; $i < strlen($hex); $i++) {
            $current = (string) strpos($chars, $hex[$i]);
            $return = (string) bcmul($return, "16");
            $return = (string) bcadd($return, $current);
        }
        return $return;
    }

    public static function encodeHex(string $dec): string
    {
        $chars = "0123456789ABCDEF";
        $return = "";
        while (bccomp($dec, 0) == 1) {
            $dv = (string) bcdiv($dec, "16");
            $rem = (integer) bcmod($dec, "16");
            $dec = $dv;
            $return = $return . $chars[$rem];
        }
        return strrev($return);
    }

    public static function base58ToNumStr(string $dictionary, string $base58): string
    {
        $return = '0';
        foreach (str_split($base58) as $b58Char) {
            $current = (string) strpos($dictionary, $b58Char);
            $return = (string) bcmul($return, '58');
            $return = (string) bcadd($return, $current);
        }

        return $return;
    }

    public static function base58ToHex(string $dictionary, string $base58): string
    {
        $return = self::base58ToNumStr($dictionary, $base58);
        $return = self::encodeHex($return);

        foreach (str_split($base58) as $b58Char) {
            if ($b58Char !== $dictionary[0]) {
                break;
            }
            $return = '00' . $return;
        }

        if (strlen($return) % 2 !== 0) {
            $return = '0' . $return;
        }

        return $return;
    }

    public static function base58ToByteStr(string $dictionary, string $base58): string
    {
        $return = '';
        foreach (str_split(self::base58ToHex($dictionary, $base58), 2) as $hexVal) {
            $return .= chr(hexdec($hexVal));
        }

        return $return;
    }

    public static function base58ToIntArr(string $dictionary, string $base58): array
    {
        $return = [];
        foreach (str_split(self::base58ToHex($dictionary, $base58), 2) as $item) {
            $return[] = hexdec($item);
        }
        return $return;
    }

    public static function base58ToBinArr(string $dictionary, string $base58): array
    {
        return array_map(function ($char) {
            return hex2bin($char);
        }, str_split(self::base58ToHex($dictionary, $base58), 2));
    }


    public static function encodeBase58(string $dictionary, string $hex): string
    {
        $orighex = $hex;

        $hex = self::decodeHex($hex);
        $return = "";
        while (bccomp($hex, 0) == 1) {
            $dv = (string) bcdiv($hex, "58");
            $rem = (integer) bcmod($hex, "58");
            $hex = $dv;
            $return = $return . $dictionary[$rem];
        }
        $return = strrev($return);

        //leading zeros
        for ($i = 0; $i < strlen($orighex) && substr($orighex, $i, 2) == "00"; $i += 2) {
            $return = '1' . $return;
        }

        return $return;
    }
}
