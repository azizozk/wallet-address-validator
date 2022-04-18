<?php

namespace WalletAddressValidator;

class Validator
{
    public static $networkAliases = [];

    public static function isValid(string $asset, string $network, string $address, $payload = null): bool
    {
        try {
            $address = AddressFactory::create($asset, $network, $address);
            if (array_key_exists($asset, self::$networkAliases)) {
                $address->setNetworkAlias(self::$networkAliases[$asset]);
            }
            if ($payload !== null) {
                $address->setParams($payload);
            }
            return $address->isValid();
        } catch (\Exception $e) {
            return false;
        }
    }
}
