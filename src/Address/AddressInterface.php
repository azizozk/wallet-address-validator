<?php

namespace WalletAddressValidator\Address;

interface AddressInterface
{
    public const BTC = 'BTC';
    public const ETH = 'ETH';
    public const LTC = 'LTC';
    public const DASH = 'DASH';
    public const HOT = 'HOT';
    public const LINK = 'LINK';
    public const DOGE = 'DOGE';
    public const XRP = 'XRP';
    public const BAT = 'BAT';
    public const XLM = 'XLM';
    public const BCH = 'BCH';
    public const MKR = 'MKR';
    public const EOS = 'EOS';
    public const XEM = 'XEM';
    public const BTG = 'BTG';
    public const ETC = 'ETC';
    public const USDT = 'USDT';
    public const TRX = 'TRX';
    public const BTT = 'BTT';
    public const ADA = 'ADA';
    public const XMR = 'XMR';
    public const ZEC = 'ZEC';

    public function __construct(string $symbol, string $network, string $address);

    public function symbol(): string;

    public function network(): string;

    public function address(): string;

    public function isValid(): bool;

    public function setParams(array $params): void;

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getParam(string $key);

    public function setNetworkAlias(array $aliases): void;
}
