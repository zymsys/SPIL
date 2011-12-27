<?php

require_once('SPIL/Loader.php');

//Mock for response class for testing
class SPIL_HTTP_Server_Response implements ISPIL_HTTP_Server_Response
{
    public function handleFlush($buffer)
    {

    }

    public function registerOutputBufferCallback($callback)
    {

    }

    public function addHeader($header)
    {

    }
}

class SPIL_REST_Handler_Test extends PHPUnit_Framework_TestCase
{
    function testMapper()
    {
        $handler = new SPIL_REST_Handler();
        $actual = $handler->getMapper();
        $this->assertTrue($actual instanceof SPIL_DataMapper_JSON);

        $handler->setMapper(new SPIL_DataMapper_FormUrlEncoded());
        $actual = $handler->getMapper();
        $this->assertTrue($actual instanceof SPIL_DataMapper_FormUrlEncoded);
    }

    /**
     * @expectedException HTTP_Request2_LogicException
     */
    function testHandleRequest()
    {
        $handler = new SPIL_REST_Handler();
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SCRIPT_NAME'] = '/SPIL_Some_Bogus_Class/5.2.1';
        $handler->handleRequest();
        $this->expectOutputString('bobotea');
    }
}