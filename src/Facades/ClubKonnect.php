<?php

namespace HenryEjemuta\LaravelClubKonnect\Facades;

use HenryEjemuta\LaravelClubKonnect\Classes\ClubKonnectResponse;
use Illuminate\Support\Facades\Facade;

/**
 * @method static ClubKonnectResponse getWalletBalance()
 * @method static ClubKonnectResponse purchaseAirtime(string $network, int $amount, $phoneNumber)
 * @method static ClubKonnectResponse purchaseDataBundle(string $network, string $plan, string $phone)
 * @method static ClubKonnectResponse verifyCableSmartCardNumber(string $cableTvType, string $smartCardNumber)
 * @method static ClubKonnectResponse purchaseCableTvPlan(string $cableTvType, string $smartCardNumber, string $plan, string $customerPhoneNumber)
 * @method static ClubKonnectResponse verifyMeterNumber(string $disco, string $meterNumber, string $meterType)
 * @method static ClubKonnectResponse purchaseElectricity(string $disco, string $meterNumber, string $meterType, $amount, string $customerPhoneNumber)
 *
 * For respective method implementation:
 * @see \HenryEjemuta\LaravelClubKonnect\ClubKonnect
 */
class ClubKonnect extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'clubkonnect';
    }
}
