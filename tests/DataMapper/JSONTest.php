<?php

require_once('SPIL/Loader.php');

class SPIL_DataMapper_JSON_Test extends PHPUnit_Framework_TestCase
{
    function getDummyObject()
    {
        $dummy = new stdClass();
        $dummy->a = 'b';
        $dummy->c = 'd';
        return $dummy;
    }

    function testInput()
    {
        $mapper = new SPIL_DataMapper_JSON();
        $expected = $this->getDummyObject();
        $actual = $mapper->input(json_encode($expected));
        $this->assertEquals($expected, $actual);
    }

    function testOutput()
    {
        $mapper = new SPIL_DataMapper_JSON();
        $actual = $mapper->output($this->getDummyObject());
        $expected = '{"a":"b","c":"d"}';
        $this->assertEquals($expected, $actual);
    }

    function testContentType()
    {
        $mapper = new SPIL_DataMapper_JSON();
        $expected = 'application/json';
        $actual = $mapper->getContentType();
        $this->assertEquals($expected, $actual);
    }

    function testPHPVersion()
    {
        $mapper = new SPIL_DataMapper_JSON();
        $expected = '5.2.0';
        $actual = $mapper->getSupportedPhpVersion();
        $this->assertEquals($expected, $actual);
    }
}