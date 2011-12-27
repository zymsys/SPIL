<?php

/**
 * Maps encoded data items such as objects or arrays to and from string encodings
 * @abstract
 */
abstract class SPIL_DataMapper_Base
{
    /**
     * Maps strings to encoded data items such as objects or arrays.
     * @abstract
     * @param $data
     * @return mixed
     */
    abstract function input($data);

    /**
     * Maps encoded data items such as objects or arrays to strings.
     * @abstract
     * @param $data mixed
     * @return string
     */
    abstract function output($data);

    /**
     * Gets mime type for the mapper
     * @abstract
     * @return string
     */
    abstract function getContentType();

}