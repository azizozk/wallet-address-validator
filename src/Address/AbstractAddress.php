<?php

namespace WalletAddressValidator\Address;

use WalletAddressValidator\Address\Validator\ValidatorInterface;

class AbstractAddress implements AddressInterface
{
    /** @var string */
    public $symbol;

    /** @var string */
    public $network;

    /** @var string */
    public $address;

    /** @var array */
    public $params;

    /** @var string[] */
    protected $networkAlias = [];

    /**
     * key by network
     * @var Validator\ValidatorInterface[]
     */
    protected $validators = [];

    public function __construct(string $symbol, string $network, string $address)
    {
        $this->symbol = $symbol;
        $this->network = $network;
        $this->address = $address;
    }

    public function symbol(): string
    {
        return $this->symbol;
    }

    public function network(): string
    {
        return $this->network;
    }

    public function address(): string
    {
        return $this->address;
    }

    public function isValid(): bool
    {
        $validator = $this->getValidator();
        if ($validator instanceof ValidatorInterface) {
            return $validator->validate();
        }

        return false;
    }

    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    public function getParam(string $key)
    {
        return $this->params[$key] ?? null;
    }

    public function setNetworkAlias(array $aliases): void
    {
        $this->networkAlias = $aliases;
    }

    public function __toString(): string
    {
        return $this->address;
    }

    protected function getValidator(): ?Validator\ValidatorInterface
    {
        $validatorClass = $this->validators[$this->network]
            ?? $this->validators[$this->networkAlias[$this->network] ?? null]
            ?? null;

        if ($validatorClass === null) {
            // network not found
            return null;
        }

        return new $validatorClass($this);
    }
}
