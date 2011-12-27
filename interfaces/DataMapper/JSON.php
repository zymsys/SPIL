<?php

/**
 * Maps PHP objects to and from their JSON equivalents.
 */
interface ISPIL_DataMapper_JSON
{
    /**
     * Maps JSON strings to PHP objects
     * @abstract
     * @param $data string
     * @return stdClass
     */
    function input($data);

    /**
     * Maps PHP objects to JSON strings
     * @abstract
     * @param $data stdClass
     * @return string
     */
    function output($data);

    /**
     * Gets mime type for the mapper: application/json
     * @abstract
     * @return string
     */
    function getContentType();
}
