<?php

namespace App\Classes;
/**
 * This exception represents a generic API exception
 */
class PassSlotApiException extends Exception
{
    /**
     * Creates an API exception
     *
     * @param string $message Error message
     * @param int $code HTTP status code
     */
    public function __construct($message, $code = 0)
    {
        $json = json_decode($message);
        parent::__construct($json ? $json->message : $message, $code);
    }
    /**
     * Returns string representation of an api exception
     *
     * @return string String representation of exception
     */
    public function __toString()
    {
        return "[{$this->code}]: {$this->message}\n";
    }
    /**
     * Return the HTTP statuc code
     * @return int HTTP status code
     */
    public function getHTTPCode()
    {
        return parent::getCode();
    }
}
/**
 * This exception represents an Unauthorized exception. This exception will be thrown the the app key is invalid
 */
class PassSlotApiUnauthorizedException extends PassSlotApiException
{
    /**
     * Creates an unauthorized exception.
     */
    public function __construct()
    {
        parent::__construct('Unauthorized. Please check your app key and make sure it has access to the template and pass type id', 401);
    }
}
/**
 * This exception represents an Validation exception. This exception will be thrown if the validation
 * of the pass values or other conent has failed.
 */
class PassSlotApiValidationException extends PassSlotApiException
{
    /**
     * Creates an validation exception based on API response
     *
     * @param string $response JSON resonse string from API call
     */
    public function __construct($response)
    {
        $json = json_decode($response);
        if ($json) {
            $msg = $json->message;
            foreach ($json->errors as $error) {
                $msg .= '; ' . $error->field . ': ' . implode(', ', $error->reasons);
            }
            parent::__construct($msg, 422);
        } else {
            parent::__construct('Validation Failed', 422);
        }
    }
}
