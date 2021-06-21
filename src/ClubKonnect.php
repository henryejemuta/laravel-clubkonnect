<?php

namespace HenryEjemuta\LaravelClubKonnect;

use HenryEjemuta\LaravelClubKonnect\Classes\ClubKonnectResponse;
use HenryEjemuta\LaravelClubKonnect\Enums\NetworkEnum;
use Illuminate\Support\Facades\Http;

class ClubKonnect
{
    /**
     * base url
     *
     * @var string
     */
    private $baseUrl;

    /**
     * the session key
     *
     * @var string
     */
    protected $instanceName;

    protected $config;

    public function __construct($baseUrl, $instanceName, $config)
    {
        $this->baseUrl = $baseUrl;
        $this->instanceName = $instanceName;
        $this->config = $config;
    }

    /**
     * get instance name of the cart
     *
     * @return string
     */
    public function getInstanceName()
    {
        return $this->instanceName;
    }

    /**
     * @param string $endpoint
     * @param array $params
     * @return ClubKonnectResponse
     */
    public function withAuth(string $endpoint, array $params = []): ClubKonnectResponse
    {
        $params['UserID'] = $this->config['user_id'];
        $params['APIKey'] = urldecode($this->config['api_key']);
        $response = Http::get("{$this->baseUrl}$endpoint", $params);
        $responseObject = json_decode($response->body());

        if ($response->getStatusCode() == 200)
            return new ClubKonnectResponse($responseObject);
        return new ClubKonnectResponse();
    }

    /**
     * Check your Server IP
     * @return ClubKonnectResponse
     */
    public function checkYourServerIP(): ClubKonnectResponse
    {
        return $this->withAuth('APIServerIPV1.asp');
    }

    /**
     * Get Your wallet available balance, Wallet is identified by username set in clubkonnect config or environmental variable
     * @return ClubKonnectResponse
     */
    public function getWalletBalance(): ClubKonnectResponse
    {
        return $this->withAuth('APIWalletBalanceV1.asp');
    }

    /**
     * @param NetworkEnum $mobileNetwork
     * @param int $amount
     * @param $phoneNumber
     * @param $requestID
     * @param $callbackUrl
     * @return ClubKonnectResponse
     */
    public function purchaseAirtime(NetworkEnum $mobileNetwork, int $amount, $phoneNumber, $requestID, $callbackUrl): ClubKonnectResponse
    {
        return $this->withAuth('APIAirtimeV1.asp', [
            'MobileNetwork' => $mobileNetwork->getCode(),
            'Amount' => $amount,
            'MobileNumber' => $phoneNumber,
            'RequestID' => $requestID,
            'CallBackURL' => $callbackUrl
        ]);
    }

    private $transaction;

    /**
     * ClubKonnect API Transaction handler to access:
     * CableTv()->queryByOrderID(string $orderID);
     * CableTv()->queryByRequestID(string $requestID);
     * CableTv()->cancelTransaction(string $orderID);
     *
     * @return Transaction
     */
    public function Transaction(): Transaction
    {
        if (is_null($this->transaction))
            $this->transaction = new class($this) extends Transaction {
            };
        return $this->transaction;
    }

    private $smile;

    /**
     * Smile Bill handler to access:
     * CableTv()->getDataBundles();
     * CableTv()->verifySmileAccountID($phoneNumber);
     * CableTv()->purchaseBundle(string $plan, string $phoneNumber, $requestID, $callbackUrl = null);
     *
     * @return Smile
     */
    public function Smile(): Smile
    {
        if (is_null($this->smile))
            $this->smile = new class($this, $this->config) extends Smile {
            };
        return $this->smile;
    }

    private $cableTv;

    /**
     * Cable TV Bill handler to access:
     * CableTv()->getTvPackages();
     * CableTv()->verifyCustomerID(CableTvEnum $cableTv, $smartCardNo);
     * CableTv()->purchasePackage(CableTvEnum $cableTv, string $package, $smartCardNo, $requestID, $callbackUrl = null);
     *
     * @return CableTv
     */
    public function CableTv(): CableTv
    {
        if (is_null($this->cableTv))
            $this->cableTv = new class($this, $this->config) extends CableTv {
            };
        return $this->cableTv;
    }

    private $rechargeCardPrinting;

    /**
     * Recharge Card Printing handler to access:
     * RechargeCardPrinting()->getEPinNetworks();
     * RechargeCardPrinting()->buyEPins(NetworkEnum $network, $amount, int $quantity, $requestID, $callbackUrl = null);
     *
     * @return RechargeCardPrinting
     */
    public function RechargeCardPrinting(): RechargeCardPrinting
    {
        if (is_null($this->rechargeCardPrinting))
            $this->rechargeCardPrinting = new class($this, $this->config) extends RechargeCardPrinting {
            };
        return $this->rechargeCardPrinting;
    }


    /**
     * Get all Data Bundles
     * @return ClubKonnectResponse
     */
    public function getDataBundles(): ClubKonnectResponse
    {
        return $this->withAuth('APIDatabundlePlansV1.asp', []);
    }


    /**
     * @param NetworkEnum $network
     * @param string $plan
     * @param string $phoneNumber
     * @param $requestID
     * @param $callbackUrl
     * @return ClubKonnectResponse
     */
    public function purchaseDataBundle(NetworkEnum $network, string $plan, string $phoneNumber, $requestID, $callbackUrl): ClubKonnectResponse
    {
        return $this->withAuth('APIDatabundleV1.asp', [
            'MobileNetwork' => $network->getCode(),
            'DataPlan' => $plan,
            'MobileNumber' => $phoneNumber,
            'RequestID' => $requestID,
            'CallBackURL' => $callbackUrl
        ]);
    }


    private $electricity;

    /**
     * Electricity Bills payment handler to access:
     * Electricity()->getDiscosAndMinMax();
     * Electricity()->verifyMeterNumber(DiscoEnum $disco, $meterNumber): ClubKonnectResponse
     * Electricity()->buyElectricity(DiscoEnum $disco, $meterNumber, $amount, MeterTypeEnum $meterType, $requestID, $callbackUrl = null): ClubKonnectResponse
     *
     * @return Electricity
     */
    public function Electricity(): Electricity
    {
        if (is_null($this->electricity))
            $this->electricity = new class($this, $this->config) extends Electricity {
            };
        return $this->electricity;
    }
}
