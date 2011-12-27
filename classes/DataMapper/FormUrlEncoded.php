<?php

/**
 * Maps arrays to and from key value pairs as used by HTTP for encoding forms.
 */
class SPIL_DataMapper_FormUrlEncoded implements ISPIL_DataMapper_Base
{
    /**
     * Maps strings to arrays.  'a=b&c=d' becomes array('a'=>'b', 'c'=>'d').
     * @param $data
     * @return array
     */
    function input($data)
    {
        $decoded = array();
        parse_str($data, $decoded);
        return $decoded;
    }

    /**
     * Maps arrays to strings.  array('a'=>'b', 'c'=>'d') becomes 'a=b&c=d'.
     * @param $data
     * @return string
     */
    function output($data)
    {
        return http_build_query($data);
    }

    /**
     * Gets mime type for the mapper: application/x-www-formurlencoded
     * @return string
     */
    function getContentType()
    {
        return 'application/x-www-formurlencoded';
    }

    /**
     * Get the minimum PHP version supported by this class
     * @return string
     */
    function getSupportedPhpVersion()
    {
        return '4.0.3';
    }
}