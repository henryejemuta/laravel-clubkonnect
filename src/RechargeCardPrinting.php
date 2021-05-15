<?php
/**
 * Created By: Henry Ejemuta
 * PC: Enrico Systems
 * Project: laravel-clubkonnect
 * Company: Stimolive Technologies Limited
 * Class Name: Transaction.php
 * Date Created: 5/14/21
 * Time Created: 10:24 AM
 */

namespace HenryEjemuta\LaravelClubKonnect;

use HenryEjemuta\LaravelClubKonnect\Classes\ClubKonnectResponse;
use HenryEjemuta\LaravelClubKonnect\Enums\NetworkEnum;

abstract class RechargeCardPrinting
{
    private $config;
    private $clubKonnect;

    public function __construct(ClubKonnect $clubKonnect, $config)
    {
        $this->config = $config;
        $this->clubKonnect = $clubKonnect;
    }

    /**
     * @return ClubKonnectResponse
     * @throws Exceptions\ClubKonnectErrorException
     */
    public function getEPinNetworks(): ClubKonnectResponse
    {
        return $this->clubKonnect->withAuth('APIEPINDiscountV1.asp', []);
    }

    /**
     * @param NetworkEnum $network
     * @param $amount
     * @param int $quantity
     * @param $requestID
     * @param $callbackUrl
     * @return ClubKonnectResponse
     * @throws Exceptions\ClubKonnectErrorException
     */
    public function buyEPins(NetworkEnum $network, $amount, int $quantity, $requestID, $callbackUrl = null): ClubKonnectResponse
    {
        $callbackUrl = is_null($callbackUrl) ? $this->config['default_redirect_url'] : $callbackUrl;
        return $this->clubKonnect->withAuth('APIEPINV1.asp', [
            'MobileNetwork' => $network->getCode(),
            'Value' => $amount,
            'Quantity' => $quantity,
            'RequestID' => $requestID,
            'CallBackURL' => $callbackUrl
        ]);
    }

}
