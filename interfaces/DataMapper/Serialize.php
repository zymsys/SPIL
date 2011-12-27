<?php

interface ISPIL_DataMapper_Serialize
{
    function input($data);
    function output($data);
    function getContentType();
}
