<?php

namespace WalletAddressValidator\Address\Validator;

use WalletAddressValidator\Address\AddressInterface;

interface ValidatorInterface
{
    public function __construct(AddressInterface $address);

    public function validate(): bool;
}
