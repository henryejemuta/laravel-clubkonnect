<?php
/**
 * Created By: Henry Ejemuta
 * PC: Enrico Systems
 * Project: laravel-clubkonnect
 * Company: Stimolive Technologies Limited
 * Class Name: ClubKonnectResponse.php
 * Date Created: 9/27/20
 * Time Created: 6:00 PM
 */

namespace HenryEjemuta\LaravelClubKonnect\Classes;


use HenryEjemuta\LaravelClubKonnect\Enums\ClubKonnectStatusCodeEnum;
use HenryEjemuta\LaravelClubKonnect\Exceptions\ClubKonnectErrorException;

class ClubKonnectResponse
{
    private $message;

    /**
     * @var bool
     */
    private $hasError;

    /**
     * @var int
     */
    private $code;

    /**
     * @var ClubKonnectStatusCodeEnum
     */
    private $clubKonnectStatusCodeEnum;

    /**
     * Response Body from
     * @var object|null $body
     */
    private $body;


    /**
     * ClubKonnectResponse constructor.
     * @param int $code
     * @param string $message
     * @param object|array|null $responseBody
     * @throws ClubKonnectErrorException
     */
    public function __construct($responseBody = null)
    {
        if (isset($responseBody->status)) {
            $statusCode = ClubKonnectStatusCodeEnum::getByStatus($responseBody->status);
            $this->code = $statusCode->getCode();
            $this->message = $statusCode->getRemark();
        } else {
            $this->code = 200;
            $this->message = '';
            $this->clubKonnectStatusCodeEnum = '';
        }

        $this->body = $responseBody;
        $this->hasError = !in_array($this->code, ClubKonnectStatusCodeEnum::$successCodes);

        if ($this->hasError) {
            $statusCode = ($this->code == "failed") ? 503 : ($this->code == "upgrade") ? 401 : 422;
            throw new ClubKonnectErrorException($message, $statusCode);
        }

    }

    /**
     * Determine if this ise a success response object
     * @return bool
     */
    public function successful(): bool
    {
        return !($this->hasError);
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return object|array|null
     */
    public function getBody()
    {
        return $this->body;
    }

    public function __toString()
    {
        return json_encode($this->body);
    }

}
