<?php
/**
 * Created By: Henry Ejemuta
 * PC: Enrico Systems
 * Project: laravel-clubkonnect
 * Company: Stimolive Technologies Limited
 * Class Name: ClubKonnectErrorException.php
 * Date Created: 9/27/20
 * Time Created: 7:24 PM
 */

namespace HenryEjemuta\LaravelClubKonnect\Exceptions;


class ClubKonnectErrorException extends \Exception
{
    /**
     * ClubKonnectErrorException constructor.
     * @param string $message
     * @param $code
     */
    public function __construct(string $message, $code)
    {
        parent::__construct($message, $code);
    }
}
