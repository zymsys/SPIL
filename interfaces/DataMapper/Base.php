<?php

/**
 * Maps encoded data items such as objects or arrays to and from string encodings
 */
interface ISPIL_DataMapper_Base
{
    /**
     * Maps strings to encoded data items such as objects or arrays.
     * @abstract
     * @param $data
     * @return mixed
     */
    function input($data);

    /**
     * Maps encoded data items such as objects or arrays to strings.
     * @abstract
     * @param $data mixed
     * @return string
     */
    function output($data);

    /**
     * Gets mime type for the mapper
     * @abstract
     * @return string
     */
    function getContentType();
}
