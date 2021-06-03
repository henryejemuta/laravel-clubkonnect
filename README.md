# Laravel ClubKonnect

[![Build Status](https://travis-ci.org/henryejemuta/laravel-clubkonnect.svg?branch=master)](https://travis-ci.org/henryejemuta/laravel-clubkonnect)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/henryejemuta/laravel-clubkonnect.svg?style=flat-square)](https://packagist.org/packages/henryejemuta/laravel-clubkonnect)
[![Latest Stable Version](https://poser.pugx.org/henryejemuta/laravel-clubkonnect/v/stable)](https://packagist.org/packages/henryejemuta/laravel-clubkonnect)
[![Total Downloads](https://poser.pugx.org/henryejemuta/laravel-clubkonnect/downloads)](https://packagist.org/packages/henryejemuta/laravel-clubkonnect)
[![License](https://poser.pugx.org/henryejemuta/laravel-clubkonnect/license)](https://packagist.org/packages/henryejemuta/laravel-clubkonnect)
[![Quality Score](https://img.shields.io/scrutinizer/g/henryejemuta/laravel-clubkonnect.svg?style=flat-square)](https://scrutinizer-ci.com/g/henryejemuta/laravel-clubkonnect)

## What is ClubKonnect
The ClubKonnect API is an HTTPs GET API that allows you to integrate all ClubKonnect virtual top-up and bills payment services available on our platform with your application (websites, desktop apps & mobile apps). You can also start your own VTU business by integrating our VTU API and resell our services in Nigeria.

## What is Laravel ClubKonnect
Laravel ClubKonnect is a laravel package to seamlessly integrate ClubKonnect api within your laravel application.

Create a ClubKonnect Account [Sign Up](https://www.clubkonnect.com/Register.asp).

Look up ClubKonnect API Documentation [API Documentation](https://www.clubkonnect.com/APIDocs.asp).

## Installation

You can install the package via composer:

```bash
composer require henryejemuta/laravel-clubkonnect
```

Publish ClubKonnect configuration file, migrations as well as set default details in .env file:

```bash
php artisan clubkonnect:init
```

## Usage

**Important: Kindly use the ``$response->successful()`` to check the response state before proceeding with working with the response and gracefully throw and handle the ClubKonnectErrorException on failed request**

Before initiating any transaction kindly check your balance to confirm you have enough ClubKonnect balance to handle the transaction

The Laravel ClubKonnect Package is quite easy to use via the ClubKonnect facade
``` php
use HenryEjemuta\LaravelClubKonnect\Facades\ClubKonnect;
use HenryEjemuta\LaravelClubKonnect\Classes\ClubKonnectResponse;

...
//Check ClubKonnect Balance
    $response = ClubKonnect::getWalletBalance();
    if ($response->successful()) {
        $body = $response->getBody();
        echo "Your {$body->phoneno} ClubKonnect Balance is {$body->balance}";
    } else {
        $exception = $response->getErrorException();
        Log::error("Error while checking balance\n\r" . $exception->getCode() . ": " . $exception->getMessage());
    }

//To buy Airtime
    $response = ClubKonnect::purchaseAirtime(NetworkEnum::getNetwork('mtn'), '1500', '08134567890', 'MY_UNIQUE_TXN_ID', 'https://example.com/afterorderurl');
    if (!$response->successful()) {
            $exception = $response->getErrorException();
        Log::error("Error while purchasing airtime\n\r" . $exception->getCode() . ": " . $exception->getMessage());
    }

...

```


Find an overview of all method with comment on what they do and expected arguments
``` php

        /**
         * Check your Server IP
         * @return ClubKonnectResponse
         */
        public function checkYourServerIP(): ClubKonnectResponse
    
        /**
         * Get Your wallet available balance, Wallet is identified by username set in clubkonnect config or environmental variable
         * @return ClubKonnectResponse
         */
        public function getWalletBalance(): ClubKonnectResponse
    
        /**
         * @param NetworkEnum $mobileNetwork
         * @param int $amount
         * @param $phoneNumber
         * @param $requestID
         * @param $callbackUrl
         * @return ClubKonnectResponse
         */
        public function purchaseAirtime(NetworkEnum $mobileNetwork, int $amount, $phoneNumber, $requestID, $callbackUrl): ClubKonnectResponse
    
        /**
         * ClubKonnect API Transaction handler to access:
         * CableTv()->queryByOrderID(string $orderID);
         * CableTv()->queryByRequestID(string $requestID);
         * CableTv()->cancelTransaction(string $orderID);
         *
         * @return Transaction
         */
        public function Transaction(): Transaction
    
        /**
         * Smile Bill handler to access:
         * CableTv()->getDataBundles();
         * CableTv()->verifySmileAccountID($phoneNumber);
         * CableTv()->purchaseBundle(string $plan, string $phoneNumber, $requestID, $callbackUrl = null);
         *
         * @return Smile
         */
        public function Smile(): Smile
    
        /**
         * Cable TV Bill handler to access:
         * CableTv()->getTvPackages();
         * CableTv()->verifyCustomerID(CableTvEnum $cableTv, $smartCardNo);
         * CableTv()->purchasePackage(CableTvEnum $cableTv, string $package, $smartCardNo, $requestID, $callbackUrl = null);
         *
         * @return CableTv
         */
        public function CableTv(): CableTv
    
        /**
         * Recharge Card Printing handler to access:
         * RechargeCardPrinting()->getEPinNetworks();
         * RechargeCardPrinting()->buyEPins(NetworkEnum $network, $amount, int $quantity, $requestID, $callbackUrl = null);
         *
         * @return RechargeCardPrinting
         */
        public function RechargeCardPrinting(): RechargeCardPrinting
    
    
        /**
         * Get all Data Bundles
         * @return ClubKonnectResponse
         */
        public function getDataBundles(): ClubKonnectResponse
    
    
        /**
         * @param NetworkEnum $network
         * @param string $plan
         * @param string $phoneNumber
         * @param $requestID
         * @param $callbackUrl
         * @return ClubKonnectResponse
         */
        public function purchaseDataBundle(NetworkEnum $network, string $plan, string $phoneNumber, $requestID, $callbackUrl): ClubKonnectResponse

```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email henry.ejemuta@gmail.com instead of using the issue tracker.

## Credits

- [Henry Ejemuta](https://github.com/henryejemuta)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
