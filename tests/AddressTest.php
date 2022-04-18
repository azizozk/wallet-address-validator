<?php

namespace WalletAddressValidator\Test;

use PHPUnit\Framework\TestCase;
use WalletAddressValidator\Address\Network;
use WalletAddressValidator\AddressFactory;
use WalletAddressValidator\Validator;

class AddressTest extends TestCase
{
    public function testFailures()
    {
        $this->expectException(\OutOfBoundsException::class);
        $this->tryAddresses('NONE', 'BTC', [
            '3Binkv2nwkvNxcF9pvc27W51VBP5Ys9t2W' => false,
        ]);

        $this->expectException(\OutOfBoundsException::class);
        $this->tryAddresses('BTC', 'NONE', [
            '3Binkv2nwkvNxcF9pvc27W51VBP5Ys9t2W' => false,
        ]);
    }

    public function testBtc()
    {
        $this->tryAddresses('BTC', 'BTC', $this->withCommons([
            '167FQQrBLUmhfMiYSEHaBprp34fphBiLm6'=> true, // BTC
            '3Binkv2nwkvNxcF9pvc27W51VBP5Ys9t2W'=> true,
            '1LNkDkf4rtKRozGTpPRbPtYJnY2q5N5bFW'=> true,
            '31hPmKswv7MnyKfGkwppee88mA1k4F1xPS'=> true,
            '3CyWjNfTscP38G7XR8GgUkHEfQ3cJqv9xE'=> true,
            '0x25bb155b18958983bb380e738bf676169e7cd531'=> false, // ERC20
            // '0x25bb155b18958983bb380e738bf676169e7cd531'=> false, // BEP20
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23'=> ['memo'=> '104067442', 'assertion' => false], // BEP2
            'bc1qhhm5qj0l0zvrcr92nyz5l7usmxn90tkr6ed0an' => false, // SEGWIT
        ]));
    }

    public function testEth()
    {
        $this->tryAddresses('ETH', 'ETH', $this->withCommons([
            '1LNkDkf4rtKRozGTpPRbPtYJnY2q5N5bFW' => false, // BTC
            '0x25bb155b18958983bb380e738bf676169e7cd531'=> true, // ERC20
            '0x1ad91ee08f21be3de0ba2ba6918e714da6b45836'=> true,
            '0x5238d5ba8e44ffb68e6d8ff75d86d35a9b822785'=> true,
            '0x97122dDca38c29b7653D52b07998d06a7128fa0B'=> true,
            '0x88e0bfff95f165ac696bee31848a9907ee63ba7f'=> true,
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23' => ['memo'=> '104067442', 'assertion' => false], // BEP2
        ]));
    }

    public function testLtc()
    {
        $this->tryAddresses('LTC', 'LTC', $this->withCommons([
            '1LNkDkf4rtKRozGTpPRbPtYJnY2q5N5bFW' => false, // BTC
            'LcAVnLSTEL2Lj2SWbp1sj1dcJnMMFDTEwe' => true, // LTC
            'LdPwbZnPB6J7fnVZVaADxVBiSVGjGwV4AZ' => true,
            'LXjpkUytDrRtyhurY75FAii1L5YVE97MZz' => true,
            'M9RA4VtQ2uGrKtykaSE6qf1w8t4tNMYtaH' => true,
            'MF7vDsRKMfKvQBQVjheMrtFR45SXhYvkzj' => true,
            '0x25bb155b18958983bb380e738bf676169e7cd531' => false, // BEP20
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23'=> ['memo'=> '104067442', 'assertion' => false], // BEP2
        ]));
    }

    public function testDash()
    {
        $this->tryAddresses('DASH', 'DASH', $this->withCommons([
            'XktsAJiPF7TpxgsmtuWwiuWejHYvTqT6Xn' => true, // DASH
            'Xs1vfynh2zhGT5DEvFNUJGUVghuaUcdNYa' => true, // DASH
            'XtXgpP8xfvS5Ea5V2uYk9Cks1gA3svDgD1' => true, // DASH
            '7oSbs5X4KweEQRCPV3UgPWoSEiccPDS89n' => true, // DASH
            '7jEUi3PmgBzBWSTbfmFES5kp8caiSmmejy' => true, // DASH
            'XdeKSVW63FQ2fQ4WMxbQ6ZVkwtZdDqdm2o' => true, // DASH
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23' => false, // BEP2
            '0x25bb155b18958983bb380e738bf676169e7cd531' => false, // BEP20
        ]));
    }

    public function testHot()
    {
        $this->tryAddresses('HOT', 'ETH', $this->withCommons([
            // Please ensure you are depositing Holo (HOT) tokens under the contract address ending in 526e2.
            '0x25bb155b18958983bb380e738bf676169e7cd531' => true, // ERC20
            '0x5Fd33Ebea4200f9B47D670A52D2d27212A32e5C5' => true, // ERC20
            '0xbeddfcc0c0edc2fcb992e8125bf2ebeaee8cb2e2' => true, // ERC20
            '0xb87e0be54250c4FF464B35972074B4b5B71b58Ca' => true, // ERC20
            '0x39d278316c39a0cadce1ebcb129fa64cf6902f97' => true, // ERC20
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23' => false, // BEP2
        ]));
    }

    public function testLink()
    {
        $this->tryAddresses('LINK', 'ETH', $this->withCommons([
            '0x25bb155b18958983bb380e738bf676169e7cd531' => true, // ERC20
            '0x564286362092d8e7936f0549571a803b203aaced' => true, // ERC20
            '0xab5719abea0b36c8d027f2453196d2619370bd00' => true, // ERC20
            '0xb28f28b9e900c569ff5717a133107015b85f1359' => true, // ERC20
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23'=> ['memo'=> '104067442', 'assertion' => false], // BEP2
        ]));
    }

    public function testDoge()
    {
        $this->tryAddresses('DOGE', 'DOGE', $this->withCommons([
            'DNC88K5AT9SJAxdzeCznyVuyusTEozCvVp' => true, // DOGE
            'DBRaS8QLnw3QprHN99z8buHr84uWnfyfsS' => true, // DOGE
            'DDpEZDEcaj333uac3rNMU5Z8iF5ifG9Joc' => true, // DOGE
            'DFrLZz9kCWzL5Wuj7XqzEXYZhK1hTVuYM2' => true, // DOGE
            'DFANjjEQtmrNb3VYAuyTSPNcVKK4E9sZKi' => true, // DOGE
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23'=> ['memo'=> '104067442', 'assertion' => false], // BEP2
        ]));
    }

    public function testBat()
    {
        $this->tryAddresses('BAT', 'ETH', $this->withCommons([
            '0x25bb155b18958983bb380e738bf676169e7cd531' => true, // ERC20
            '0x0d8775f648430679a709e98d2b0cb6250d2887ef' => true, // ERC20
            '0x49087b56852e9eb4204334bc808d7796a1d3b614' => true, // ERC20
            '0xb06d72896616295d7ac1fc0337fd9cf7734b896b' => true, // ERC20
            '0x79ee0687e6643c67aabab0abe836d49dbf76e0ee' => true, // ERC20
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23'=> ['memo'=> '104067442', 'assertion' => false], // BEP2
        ]));
    }

    public function testXrp()
    {
        $this->tryAddresses('XRP', 'XRP', $this->withCommons([
            'rEb8TK3gBgk5auZkwc6sHnwrGVJH8DuaLh'=> ['tag'=> '108374035', 'assertion' => true], // XRP
            'ryBANkk28Mj71jRKAkt13U1X9ubztsGWZ'=> ['tag'=> '851882565', 'assertion' => true], // XRP
            '0x25bb155b18958983bb380e738bf676169e7cd531' => false, // BEP20
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23'=> ['memo'=> '104067442', 'assertion' => false], // BEP2
        ]));
    }

    public function testXlm()
    {
        // https://stellarchain.io/
        $this->tryAddresses('XLM', 'XLM', $this->withCommons([
            '0x25bb155b18958983bb380e738bf676169e7cd531' => false, // ERC20
            'TNGNYjStMYALYbCQBmwTb1rjgutUQtQYHC' => false, // TRC20
            'GBBALM76B5OUPOZCMFCNT5PVIFV3WTUYX3VVGC7FMN4ZPQLGCG2C4X3D' => ['memo'=> '12345678901234567890123456789', 'assertion' => false],
            'GABWDIF2UM5HV7TQ5U5YB6YQJVXX76LRUPVMWKWQOO3TANRIRQJFZ6X2' => ['memo'=> '1234567890123456789012345678', 'assertion' => true],
            'GAHK7EEG2WWHVKDNT4CEQFZGKF2LGDSW2IVM4S5DP42RBW3K6BTODB4A' => ['memo'=> '1034560979', 'assertion' => true], // XLM
            'GAUJETIZVEP2NRYLUESJ3LS66NVCEGMON4UDCBCSBEVPIID773P2W6AY' => ['memo'=> '565969678', 'assertion' => true], // XLM
            'GAVF6ZB7Z7FKCWM5HEY2OV4ENPK3OSSHMFTVR4HHSBFHKW36U3FUH2CB' => ['assertion' => true], // XLM
        ]));
    }

    public function testMkr()
    {
        // etherscan mkr
        $this->tryAddresses('MKR', 'ETH', $this->withCommons([
            '0x25bb155b18958983bb380e738bf676169e7cd531' => true, // ERC20
            '0xca0762b1bbd6f35cf29bbff654beb3904e961724' => true, // ERC20
            // '0x25bb155b18958983bb380e738bf676169e7cd531' => true, // BEP20
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23'=> ['memo'=> '104067442', 'assertion' => false], // BEP2
        ]));
    }

    public function testBch()
    {
        // https://explorer.bitcoin.com/bch
        $this->tryAddresses('BCH', 'BCH', $this->withCommons([
            '1LNkDkf4rtKRozGTpPRbPtYJnY2q5N5bFW' => true, // BTC
            'bitcoincash:qpha0dhk3hf82svr7ljxtxzyzjwckhuwrywjm7l860' => true, // BCH
            'bitcoincash:qzrekysp60l4px6c0hq3fzzrz7vq5taghqs8ylefgx' => true, // BCH
            'bitcoincash:qzpv4e6mhr9zl47d4wgtrwq442g7g6wy0cuz2duq9h' => true, // BCH
            '1BCNRQyE1ZPGSL3hJNc4H7U9r2zGrMGU1Z' => true, // BCH legacy
            '167FQQrBLUmhfMiYSEHaBprp34fphBiLm6' => true, // BCH  legacy
            '0x25bb155b18958983bb380e738bf676169e7cd531' => false, // ERC20
            // '0x25bb155b18958983bb380e738bf676169e7cd531' => false, // BEP20
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23'=> ['memo'=> '104067442', 'assertion' => false], // BEP2
        ]));
    }

    public function testEos()
    {
        // https://eostracker.io/
        $this->tryAddresses('EOS', 'EOS', $this->withCommons([
            '3CyWjNfTscP38G7XR8GgUkHEfQ3cJqv9xE' => false, // BTC
            'binancecleos' => ['memo'=> '101418505', 'assertion' => true], // EOS
            'koineksadres' => ['memo'=> '624245714', 'assertion' => true], // EOS
            // 'koineksadres' => ['memo'=> '624245714', 'assertion' => true], // EOS
            '0x25bb155b18958983bb380e738bf676169e7cd531' => false, // BEP20
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23'=> ['memo'=> '104067442', 'assertion' => false], // BEP2
        ]));
    }

    public function testXem()
    {
        $this->tryAddresses('XEM', 'XEM', $this->withCommons([
            'NC64UFOWRO6AVMWFV2BFX2NT6W2GURK2EOX6FFMZ' => ['memo'=> '107187264', 'assertion' => true], // XEM
            'NDROMSHKOBMDEXYI3Y7VB2XN35YNE5P5HCGAUER4' => ['memo'=> '495175104', 'assertion' => true], // XEM
            'NDROMSHKOBMDEXYI3Y7VB2XN35YNE5P5HCGAUERX' => ['memo'=> '495175104', 'assertion' => false], // XEM
            'XDROMSHKOBMDEXYI3Y7VB2XN35YNE5P5HCGAUERX' => ['memo'=> '495175104', 'assertion' => false], // XEM
            '0x25bb155b18958983bb380e738bf676169e7cd531' => false, // ERC20
            '3CyWjNfTscP38G7XR8GgUkHEfQ3cJqv9xE' => false, // BTC
        ]));

        $this->tryAddresses('XEM', 'XEM', [
            'NDROMSHKOBMDEXYI3Y7VB2XN35YNE5P5HCGAUER4' => true
        ]);
    }

    /**
     * https://explorer.bitcoingold.org/insight/block/0000000494152fbd0c215e04269b92970b710a6baa16832399efe9f9e8c276eb
     */
    public function testBtg()
    {
        $this->tryAddresses('BTG', 'BTG', $this->withCommons([
            '0x25bb155b18958983bb380e738bf676169e7cd531' => false,
            '3CyWjNfTscP38G7XR8GgUkHEfQ3cJqv9xE' => false, // BTC
            'XW78NPTkHsz3YfoYFq8zW96x1Nc7MW86xA' => false, // malformed
            'GW78NPTkHsz3YfoYFq8zW96x1Nc7MW86xA' => true,
            'AXQKTr9vLDTfLcxwhHCToLcZjDi9KtQbKP' => true,
            'APkihUKhUjoTyeB6wihyomTLQXWdfJhjPv' => true,
            'GKkrxKeNMWRNsQpwSiqi5gao94xKKSJvV7' => true,
            'GWtsL9YnKJdAQ4qtXHiuB5PsRYG335Sbgd' => true,
            'GJambyfwHsCrhNB665Er7Gx3BexpUgEyZq' => true,
            'GQDF7X8qw1wF2NfQo3kfJ9Acdh4RhczgDE' => true,
            'AVYRUEuXctTbNijA8tXbfLMaDyRp4jirXN' => true,
            'TNGNYjStMYALYbCQBmwTb1rjgutUQtQYHC' => false, // TRC20
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23'=> ['memo'=> '104067442', 'assertion' => false], // BEP2
        ]));
    }

    public function testEtc()
    {
        $this->tryAddresses('ETC', 'ETH', $this->withCommons([
            '0x25bb155b18958983bb380e738bf676169e7cd531' => true, // ETC
            '4468952d341359da979262301d8be5636afcd3e8' => true, // ETC
            'TNGNYjStMYALYbCQBmwTb1rjgutUQtQYHC' => false, // TRC20
            '3CyWjNfTscP38G7XR8GgUkHEfQ3cJqv9xE' => false, // BTC
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23'=> ['memo'=> '104067442', 'assertion' => false], // BEP2
        ]));
    }

    public function testUsdt()
    {
        $this->tryAddresses('USDT', 'ETH', $this->withCommons([
            '0x25bb155b18958983bb380e738bf676169e7cd531' => true, // ERC20
            '0x5e8306c6f9c46cd48522a2aab5d7cbb1c5f2ede9' => true, // ERC20
            '1KL6n25utGRYXWyiU1SJkaqrYWYD6FurEo' => false, // OMNI
            'TNGNYjStMYALYbCQBmwTb1rjgutUQtQYHC' => false, // TRC20
            // '0x25bb155b18958983bb380e738bf676169e7cd531' => false, // BEP20
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23'=> ['memo'=> '104067442', 'assertion' => false], // BEP2
        ]));

        $this->tryAddresses('USDT', 'OMNI', $this->withCommons([
            '1KL6n25utGRYXWyiU1SJkaqrYWYD6FurEo' => true,
            '1451oXRTetETBi5sFKLSLuwoL2vNR48x2U' => true,
            'TNGNYjStMYALYbCQBmwTb1rjgutUQtQYHC' => false, // TRC20
            '0x25bb155b18958983bb380e738bf676169e7cd531' => false, // BEP20
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23'=> ['memo'=> '104067442', 'assertion' => false], // BEP2
        ]));

        $this->tryAddresses('USDT', 'TRC20', $this->withCommons([
            'TNGNYjStMYALYbCQBmwTb1rjgutUQtQYHC' => true,
            '1KL6n25utGRYXWyiU1SJkaqrYWYD6FurEo' => false,
            '0x5e8306c6f9c46cd48522a2aab5d7cbb1c5f2ede9' => false, // ERC20
        ]));
    }

    public function testTrx()
    {
        $this->tryAddresses('TRX', 'TRX', $this->withCommons([
            'TNGNYjStMYALYbCQBmwTb1rjgutUQtQYHC' => true, // TRC20
            'TYMFxi9aTH5Wn72LMie1DfEtRYQXrdVpVk' => true, // TRC20
            '3CyWjNfTscP38G7XR8GgUkHEfQ3cJqv9xE' => false, // BTC
            '0x5e8306c6f9c46cd48522a2aab5d7cbb1c5f2ede9' => false, // ERC20
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23'=> ['memo'=> '104067442', 'assertion' => false], // BEP2
        ]));
    }

    public function testBtt()
    {
        $this->tryAddresses('BTT', 'TRX', $this->withCommons([
            'TS4dbhDuRPzwUBhyVQBKHgj4iaTBL1E8G2' => true, // TRC 20
            'TNGNYjStMYALYbCQBmwTb1rjgutUQtQYHC' => true, // TRC 20
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23'=> ['memo'=> '104067442', 'assertion' => false], // BEP2
        ]));
        $this->tryAddresses('BTT', 'BTT', $this->withCommons([
            'TS4dbhDuRPzwUBhyVQBKHgj4iaTBL1E8G2' => true, // TRC 20
            'TNGNYjStMYALYbCQBmwTb1rjgutUQtQYHC' => true, // TRC 20
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23'=> ['memo'=> '104067442', 'assertion' => false], // BEP2
        ]));
    }

    public function testAda()
    {
        $this->tryAddresses('ADA', 'ADA', $this->withCommons([
            'DdzFFzCqrhsvbtsmzHGgUAND9yvNc9WTM96nHWrSTQEukZyrqSWhyhv7ePPUJpp5wxPxFHYc7ZCPcUDyZLruYQNSLUCHCfFEsUyqQhim' => true, // ADA Daedalus
            'DdzFFzCqrhsrcfeLYqFbWThXHLzK4PQnHoTtB2FJL7bHmkZ1xdtxnhGPe8KSL8xtihBXTW9PKeXR9vF1pcQQDHyHkDCUKMW5a3tSMXz9' => true, // ADA Daedalus
            'Ae2tdPwUPEZFRbyhz3cpfC2CumGzNkFBN2L42rcUc2yjQpEkxDbkPodpMAi' => true, // ADA Yoroi
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23'=> ['memo'=> '104067442', 'assertion' => false], // BEP2
            '0x25bb155b18958983bb380e738bf676169e7cd531' => false, // BEP20
        ]));
    }

    public function testXmr()
    {
        $this->tryAddresses('XMR', 'XMR', $this->withCommons([
            '8BMJSiN6VGmDMR7Lq3zEQoLUnV8mJq9tzSCmy7UA33qkbG2RBb63dV6MFmQT8jLEiTaE15QndzGsDcRPJNQn8trtEXEPAXR' => true, // XMR
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23'=> ['memo'=> '104067442', 'assertion' => false], // BEP2
            '0x25bb155b18958983bb380e738bf676169e7cd531' => false, // BEP20
        ]));
    }

    public function testZec()
    {
        $this->tryAddresses('ZEC', 'ZEC', $this->withCommons([
            't1N6recT4w5xKVtKwiwjoC6SMNWz7sd1W8H' => true, // ZEC
            't1QboPyrUyjL9cWBaqEtpaADTX5sQRpL8zk' => true, // ZEC
            'bnb136ns6lfw4zs5hg4n85vdthaad7hq5m4gtkgf23'=> ['memo'=> '104067442', 'assertion' => false], // BEP2
            '0x25bb155b18958983bb380e738bf676169e7cd531' => false, // BEP20
        ]));
    }

    public function testNetworkAlias()
    {
        $networkAlias = 'BTTTRX';
        $addr = AddressFactory::create(
            'BTT',
            $networkAlias,
            'TS4dbhDuRPzwUBhyVQBKHgj4iaTBL1E8G2'
        );
        $addr->setNetworkAlias([$networkAlias => Network::TRC20]);
        $this->assertTrue($addr->isValid());

        $networkAlias = 'USDTOMNI';
        $addr = AddressFactory::create(
            'USDT',
            $networkAlias,
            '1451oXRTetETBi5sFKLSLuwoL2vNR48x2U'
        );
        $addr->setNetworkAlias([$networkAlias => Network::OMNI]);
        $this->assertTrue($addr->isValid());
    }

    public function testFactoryNetworkAlias()
    {
        Validator::$networkAliases = [
            'BTT' => [
                'BTT-TRX' => Network::TRC20
            ],
            'USDT' => [
                'USDT-OMNI' => Network::OMNI,
                'USDT-ERC20' => Network::ERC20,
                'USDT-TRC20' => Network::TRC20,
            ],
            'BTC' => [
                'SOMETHING-ELSE' => Network::BTC
            ]
        ];

        $this->assertTrue(Validator::isValid('BTT', 'BTT-TRX', 'TS4dbhDuRPzwUBhyVQBKHgj4iaTBL1E8G2'));
        $this->assertTrue(Validator::isValid('USDT', 'USDT-OMNI', '1451oXRTetETBi5sFKLSLuwoL2vNR48x2U'));
        $this->assertTrue(Validator::isValid('USDT', 'USDT-ERC20', '0x5e8306c6f9c46cd48522a2aab5d7cbb1c5f2ede9'));
        $this->assertTrue(Validator::isValid('USDT', 'USDT-TRC20', 'TNGNYjStMYALYbCQBmwTb1rjgutUQtQYHC'));
        $this->assertTrue(Validator::isValid('BTC', 'SOMETHING-ELSE', '1LNkDkf4rtKRozGTpPRbPtYJnY2q5N5bFW'));
    }

    protected function tryAddresses(string $symbol, string $network, array $addresses): void
    {
        foreach ($addresses as $address => $assertion) {
            $addr = AddressFactory::create($symbol, $network, $address);
            if (is_array($assertion)) {
                [$params, $assertion] = [$assertion, $assertion['assertion']];
                unset($params['assertion']);
                $addr->setParams($params);
            }
            $this->assertEquals($assertion, $addr->isValid());
        }
    }

    protected function withCommons(array $addition = []): array
    {
        return [
                '' => false,
                'qwerty' => false,
                'sdafasdfsdf' => false,
                'asdfasdfasdfsadfsadfasdfsadfasdfas' => false,
                '..................................' => false,
                '**********************************' => false,
        ] + $addition;
    }
}
