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
     * @var ClubKonnectErrorException
     */
    private $error;

    /**
     * @var int
     */
    private $code;

    /**
     * Response Body from
     * @var object|null $body
     */
    private $body;


    /**
     * ClubKonnectResponse constructor.
     * @param object|array|null $responseBody
     */
    public function __construct($responseBody = null)
    {
        if (isset($responseBody->status)) {
            $statusCode = ClubKonnectStatusCodeEnum::getStatusCode($responseBody->status);
            $this->code = $statusCode->getCode();
            $remark = ($responseBody->status == $statusCode->getRemark()) ? '' : $statusCode->getRemark();
            $this->message = $remark . (!empty($remark) ? ', ' : '') . $statusCode->getDescription();
        } else {
            $this->code = 200;
            $this->message = '';
        }

        $this->body = $responseBody;
        $this->hasError = !in_array($this->code, ClubKonnectStatusCodeEnum::$successCodes);

        if ($this->hasError) {
            $this->error = new ClubKonnectErrorException($this->message, $this->code);
        } else {
            $this->error = null;
        }

    }

    /**
     * Determine if this is a success response object
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
     * Returns ClubKonnectErrorException with appropriate ClubKonnect status code and Message if this isn't a successful response, otherwise, null is returned
     * @return ClubKonnectErrorException|null
     */
    public function getErrorException()
    {
        return $this->error;
    }

    /**
     * Return the response body as specified in the ClubKunnect API documentation for the corresponding request. This would be null on fail request
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
