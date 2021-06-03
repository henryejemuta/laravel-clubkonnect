<?php

namespace HenryEjemuta\LaravelClubKonnect\Facades;

use HenryEjemuta\LaravelClubKonnect\CableTv;
use HenryEjemuta\LaravelClubKonnect\Classes\ClubKonnectResponse;
use HenryEjemuta\LaravelClubKonnect\Enums\NetworkEnum;
use HenryEjemuta\LaravelClubKonnect\RechargeCardPrinting;
use HenryEjemuta\LaravelClubKonnect\Smile;
use HenryEjemuta\LaravelClubKonnect\Transaction;
use Illuminate\Support\Facades\Facade;

/**
 * @method static ClubKonnectResponse checkYourServerIP()
 * @method static ClubKonnectResponse getWalletBalance()
 * @method static ClubKonnectResponse purchaseAirtime(NetworkEnum $mobileNetwork, int $amount, $phoneNumber, $requestID, $callbackUrl)
 * @method static Transaction Transaction()
 * @method static Smile Smile()
 * @method static CableTv CableTv()
 * @method static RechargeCardPrinting RechargeCardPrinting()
 * @method static ClubKonnectResponse getDataBundles()
 * @method static ClubKonnectResponse purchaseDataBundle(NetworkEnum $network, string $plan, string $phoneNumber, $requestID, $callbackUrl)
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
