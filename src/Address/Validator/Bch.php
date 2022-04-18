<?php

namespace WalletAddressValidator\Address\Validator;

use WalletAddressValidator\Address\AddressInterface;
use WalletAddressValidator\Address\Validator\Support\CashAddress;

class Bch extends AbstractBase58
{
    const NEW_ADDRESS_PREFIX = 'bitcoincash:';

    protected $base58PrefixToHexVersion = [
        '1' => '00',
        '3' => '05'
    ];

    public function validate(): bool
    {
        if (strpos($this->address, self::NEW_ADDRESS_PREFIX) === 0) {
            $addressStr = (string) $this->address;
            if (strtolower($this->address) !== $addressStr && strtoupper($this->address) !== $addressStr) {
                return false;
            }

            if (($this->address = $this->getOldAddress($this->address)) === null) {
                return false;
            }
            $this->determineVersion($this->base58PrefixToHexVersion);
        }

        return parent::validate();
    }


    protected function getOldAddress(AddressInterface $address): ?AddressInterface
    {
        try {
            $newAddress = CashAddress::new2old($address);
            $addrClass = get_class($this->address);
            return new $addrClass(
                $address->symbol(),
                $address->network(),
                $newAddress
            );
        } catch (\Exception $e) {
            return null;
        }
    }
}
