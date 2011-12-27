<?php

class SPIL_DataMapper_Serialize implements ISPIL_DataMapper_Serialize
{
    function input($data)
    {
        return unserialize($data);
    }

    function output($data)
    {
        return serialize($data);
    }

    function getContentType()
    {
        return 'text/plain';
    }

    function getSupportedPhpVersion()
    {
        return '4.0.7';
    }
}
