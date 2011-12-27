<?php

/**
 * Maps PHP objects to and from their JSON equivalents.
 */
class SPIL_DataMapper_JSON implements ISPIL_DataMapper_Base
{
    /**
     * Maps JSON strings to PHP objects
     * @abstract
     * @param $data string
     * @return stdClass
     */
    function input($data)
    {
        return json_decode($data);
    }

    /**
     * Maps PHP objects to JSON strings
     * @abstract
     * @param $data stdClass
     * @return string
     */
    function output($data)
    {
        return json_encode($data);
    }

    /**
     * Gets mime type for the mapper: application/json
     * @abstract
     * @return string
     */
    function getContentType()
    {
        return 'application/json';
    }

    /**
     * Get the minimum PHP version supported by this class
     * @return string
     */
    function getSupportedPhpVersion()
    {
        return '5.2.0';
    }
}