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

abstract class Transaction
{
    private $clubKonnect;

    /**
     * Transactions constructor.
     * @param ClubKonnect $clubKonnect
     */
    public function __construct(ClubKonnect $clubKonnect)
    {
        $this->clubKonnect = $clubKonnect;
    }


    /**
     *
     * @param string $orderID
     * @return ClubKonnectResponse
     * @throws ClubKonnectErrorException
     */
    public function queryByOrderID(string $orderID): ClubKonnectResponse
    {
        return $this->clubKonnect->withAuth('APIQueryV1.asp', [
            'OrderID' => $orderID
        ]);
    }

    /**
     *
     * @param string $requestID
     * @return ClubKonnectResponse
     * @throws ClubKonnectErrorException
     */
    public function queryByRequestID(string $requestID): ClubKonnectResponse
    {
        return $this->clubKonnect->withAuth('APIQueryV1.asp', [
            'RequestID' => $requestID
        ]);
    }

    /**
     *
     * @param string $orderID
     * @return ClubKonnectResponse
     * @throws ClubKonnectErrorException
     */
    public function cancelTransaction(string $orderID): ClubKonnectResponse
    {
        return $this->clubKonnect->withAuth('APICancelV1.asp', [
            'OrderID' => $orderID
        ]);
    }


}
