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
use HenryEjemuta\LaravelClubKonnect\Enums\DiscoEnum;
use HenryEjemuta\LaravelClubKonnect\Enums\MeterTypeEnum;

abstract class Electricity
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
     */
    public function getDiscosAndMinMax(): ClubKonnectResponse
    {
        return $this->clubKonnect->withAuth('APIElectricityDiscosV1.asp', []);
    }

    /**
     * @param DiscoEnum $disco
     * @param $meterNumber
     * @return ClubKonnectResponse
     */
    public function verifyMeterNumber(DiscoEnum $disco, $meterNumber): ClubKonnectResponse
    {
        return $this->clubKonnect->withAuth('APIVerifyElectricityV1.asp', [
            'ElectricCompany' => $disco->getCode(),
            'MeterNo' => $meterNumber,
        ]);
    }

    /**
     * @param DiscoEnum $disco
     * @param $meterNumber
     * @param $amount
     * @param MeterTypeEnum $meterType
     * @param $requestID
     * @param $callbackUrl
     * @return ClubKonnectResponse
     */
    public function buyElectricity(DiscoEnum $disco, $meterNumber, $amount, MeterTypeEnum $meterType, $requestID, $callbackUrl = null): ClubKonnectResponse
    {
        $callbackUrl = is_null($callbackUrl) ? $this->config['default_redirect_url'] : $callbackUrl;
        return $this->clubKonnect->withAuth('APIElectricityV1.asp', [
            'ElectricCompany' => $disco->getCode(),
            'MeterNo' => $meterNumber,
            'Amount' => $amount,
            'MeterType' => $meterType->getCode(),
            'RequestID' => $requestID,
            'CallBackURL' => $callbackUrl
        ]);
    }

}
