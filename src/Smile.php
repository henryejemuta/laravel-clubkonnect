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
use HenryEjemuta\LaravelClubKonnect\Exceptions\ClubKonnectErrorException;

abstract class Smile
{
    private $config;
    private $clubKonnect;

    public function __construct(ClubKonnect $clubKonnect, $config)
    {
        $this->config = $config;
        $this->clubKonnect = $clubKonnect;
    }

    public function getDataBundles(): ClubKonnectResponse
    {
        return $this->clubKonnect->withAuth('APISmilePackagesV2.asp', []);
    }

    public function verifySmileAccountID($phoneNumber): ClubKonnectResponse
    {
        return $this->clubKonnect->withAuth('APIVerifySmileV1.asp', [
            'MobileNetwork' => 'smile-direct',
            'MobileNumber' => $phoneNumber,
        ]);
    }

    public function purchaseBundle(string $plan, string $phoneNumber, $requestID, $callbackUrl = null): ClubKonnectResponse
    {
        $callbackUrl = is_null($callbackUrl) ? $this->config['default_redirect_url'] : $callbackUrl;
        return $this->clubKonnect->withAuth('APISmileV1.asp', [
            'MobileNetwork' => 'smile-direct',
            'DataPlan' => $plan,
            'MobileNumber' => $phoneNumber,
            'RequestID' => $requestID,
            'CallBackURL' => $callbackUrl
        ]);
    }


}
