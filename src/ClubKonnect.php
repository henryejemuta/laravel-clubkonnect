<?php

namespace HenryEjemuta\LaravelClubKonnect;

use HenryEjemuta\LaravelClubKonnect\Classes\ClubKonnectResponse;
use HenryEjemuta\LaravelClubKonnect\Enums\NetworkEnum;
use HenryEjemuta\LaravelClubKonnect\Exceptions\ClubKonnectErrorException;
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
     * @throws ClubKonnectErrorException
     */
    public function withAuth(string $endpoint, array $params = []): ClubKonnectResponse
    {
        $params['UserID'] = $this->config['user_id'];
        $params['APIKey'] = urldecode($this->config['api_key']);
        $response = Http::get("{$this->baseUrl}$endpoint", $params);

        $responseObject = json_decode($response->body());
        if (isset($responseObject->code) && isset($responseObject->message))
            return new ClubKonnectResponse($responseObject->code, $responseObject->message, isset($responseObject->data) ? $responseObject->data : null);
        return new ClubKonnectResponse();
    }

    /**
     * Check your Server IP
     * @return ClubKonnectResponse
     * @throws ClubKonnectErrorException
     */
    public function checkYourServerIP(): ClubKonnectResponse
    {
        return $this->withAuth('APIServerIPV1.asp');
    }

    /**
     * Get Your wallet available balance, Wallet is identified by username set in clubkonnect config or environmental variable
     * @return ClubKonnectResponse
     * @throws ClubKonnectErrorException
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
     * @throws ClubKonnectErrorException
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
     * Get DataBundles
     * @return ClubKonnectResponse
     * @throws ClubKonnectErrorException
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
     * @throws ClubKonnectErrorException
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
}
