<?php

namespace WalletAddressValidator\Address\Validator;

use WalletAddressValidator\Address\AddressInterface;

class Eos implements ValidatorInterface
{
    /** @var AddressInterface */
    protected $address;

    public function __construct(AddressInterface $address)
    {
        $this->address = $address;
    }

    public function validate(): bool
    {
        return preg_match('/^[1-5a-z]{12}$/i', $this->address);
    }
}
