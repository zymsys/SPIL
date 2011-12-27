<?php

require_once('SPIL/Loader.php');

class SPIL_DataMapper_FormUrlEncoded_Test extends PHPUnit_Framework_TestCase
{
    function testInput()
    {
        $mapper = new SPIL_DataMapper_FormUrlEncoded();
        $actual = $mapper->input('a=b&c=d');
        $expected = array('a'=>'b', 'c'=>'d');
        $this->assertEquals($expected, $actual);
    }

    function testOutput()
    {
        $mapper = new SPIL_DataMapper_FormUrlEncoded();
        $actual = $mapper->output(array('a'=>'b', 'c'=>'d'));
        $expected = 'a=b&c=d';
        $this->assertEquals($expected, $actual);
    }

    function testContentType()
    {
        $mapper = new SPIL_DataMapper_FormUrlEncoded();
        $expected = 'application/x-www-formurlencoded';
        $actual = $mapper->getContentType();
        $this->assertEquals($expected, $actual);
    }

    function testPHPVersion()
    {
        $mapper = new SPIL_DataMapper_FormUrlEncoded();
        $expected = '4.0.3';
        $actual = $mapper->getSupportedPhpVersion();
        $this->assertEquals($expected, $actual);
    }
}