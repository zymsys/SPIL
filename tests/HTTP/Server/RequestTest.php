<?php

require_once('SPIL/Loader.php');

class SPIL_HTTP_Server_Request_Test extends PHPUnit_Framework_TestCase
{
    public function testGetMethod()
    {
        $key = 'REQUEST_METHOD';
        $request = new SPIL_HTTP_Server_Request();

        $expected = 'GET';
        $_SERVER[$key] = $expected;
        $actual = $request->getMethod();
        $this->assertEquals($expected, $actual, "GET requests indicate the GET method");

        $expected = 'POST';
        $_SERVER[$key] = $expected;
        $actual = $request->getMethod();
        $this->assertEquals($expected, $actual, "POST requests indicate the POST method");
    }

    public function testSetPath()
    {
        $key = 'SCRIPT_NAME';
        unset($_SERVER[$key]);
        $request = new SPIL_HTTP_Server_Request();
        $expected = null;
        $actual = $request->getPath();
        $this->assertEquals($expected, $actual);

        $expected = '/path/to/resource';
        $_SERVER[$key] = $expected . '/resourcename.html';
        $actual = $request->getPath();
        $this->assertEquals($expected, $actual, "SPIL_HTTP_Request::setPath() gets path from $key with full file name");

        $_SERVER[$key] = $expected . '/noextension';
        $request->setPath();
        $actual = $request->getPath();
        $this->assertEquals($expected, $actual,
            "SPIL_HTTP_Request::setPath() gets path from $key with file name that has no extension");

        $expected = '/bogus/path';
        $request->setPath($expected);
        $actual = $request->getPath();
        $this->assertEquals($expected, $actual);
    }

    public function testInsidePath()
    {
        $key = 'PATH_INFO';
        $expected = '/inside/path';
        $_SERVER[$key] = $expected;
        $request = new SPIL_HTTP_Server_Request();
        $actual = $request->getInsidePath();
        $this->assertEquals($expected, $actual);

        $expectedm = '/manual/inside/path';
        $request->setInsidePath($expectedm);
        $actual = $request->getInsidePath();
        $this->assertEquals($expectedm, $actual);

        $request = new SPIL_HTTP_Server_Request();
        $request->setInsidePath();
        $actual = $request->getInsidePath();
        $this->assertEquals($expected, $actual);
    }

    public function testProtocol()
    {
        $key = 'SERVER_PROTOCOL';
        $expected = 'HTTP/1.0';
        $_SERVER[$key] = $expected;
        $request = new SPIL_HTTP_Server_Request();
        $actual = $request->getProtocol();
        $this->assertEquals($expected, $actual);

        $expectedm = 'HTTP/1.1';
        $request->setProtocol($expectedm);
        $actual = $request->getProtocol();
        $this->assertEquals($expectedm, $actual);

        $request = new SPIL_HTTP_Server_Request();
        $request->setProtocol();
        $actual = $request->getProtocol();
        $this->assertEquals($expected, $actual);
    }
}