<?php

/**
 * Maps arrays to and from key value pairs as used by HTTP for encoding forms.
 */
interface ISPIL_DataMapper_FormUrlEncoded
{
    /**
     * Maps strings to arrays.  'a=b&c=d' becomes array('a'=>'b', 'c'=>'d').
     * @abstract
     * @param $data
     * @return array
     */
    function input($data);

    /**
     * Maps arrays to strings.  array('a'=>'b', 'c'=>'d') becomes 'a=b&c=d'.
     * @abstract
     * @param $data
     * @return string
     */
    function output($data);

    /**
     * Gets mime type for the mapper: application/x-www-formurlencoded
     * @abstract
     * @return string
     */
    function getContentType();
}
