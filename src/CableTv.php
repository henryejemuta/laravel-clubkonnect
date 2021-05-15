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
use HenryEjemuta\LaravelClubKonnect\Enums\CableTvEnum;
use HenryEjemuta\LaravelClubKonnect\Exceptions\ClubKonnectErrorException;

abstract class CableTv
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
     * @throws ClubKonnectErrorException
     */
    public function getTvPackages(): ClubKonnectResponse
    {
        return $this->clubKonnect->withAuth('APICableTVPackagesV2.asp', []);
    }

    /**
     * @param CableTvEnum $cableTv
     * @param $smartCardNo
     * @return ClubKonnectResponse
     * @throws ClubKonnectErrorException
     */
    public function verifyCustomerID(CableTvEnum $cableTv, $smartCardNo): ClubKonnectResponse
    {
        return $this->clubKonnect->withAuth('APIVerifyCableTVV1.0.asp', [
            'CableTV' => $cableTv->getCode(),
            'SmartCardNo' => $smartCardNo,
        ]);
    }

    /**
     * @param CableTvEnum $cableTv
     * @param string $package
     * @param $smartCardNo
     * @param $requestID
     * @param $callbackUrl
     * @return ClubKonnectResponse
     * @throws ClubKonnectErrorException
     */
    public function purchasePackage(CableTvEnum $cableTv, string $package, $smartCardNo, $requestID, $callbackUrl = null): ClubKonnectResponse
    {
        $callbackUrl = is_null($callbackUrl) ? $this->config['default_redirect_url'] : $callbackUrl;
        return $this->clubKonnect->withAuth('APICableTVV1.asp', [
            'CableTV' => $cableTv->getCode(),
            'MeterType' => $package,
            'SmartCardNo' => $smartCardNo,
            'RequestID' => $requestID,
            'CallBackURL' => $callbackUrl
        ]);
    }




}
