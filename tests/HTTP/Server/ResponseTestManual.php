<?php

//This class is all about output buffering and headers, etc.
//That stuff doesn't work with PHPUnit, so the tests for this class can
//be run manually in a browser, since the command line SAPI doesn't
//support headers.  D'Oh.

require_once('SPIL/Loader.php');

class SPIL_HTTP_Server_Response_Test
{
    static $count = 0;
    public $assertCount = 0;
    public $failedCount = 0;

    function assertEquals($expected, $actual)
    {
        $this->assertCount += 1;
        if ($expected != $actual)
        {
            echo "<div>Failed test.  $expected does not equal $actual.</div>";
            $this->failedCount += 1;
        }
    }
    static function obCallback($text)
    {
        SPIL_HTTP_Server_Response_Test::$count += 1;
        return $text;
    }

    function testOutputBuffer()
    {
        $originalHandlers = ob_list_handlers();
        $response = new SPIL_HTTP_Server_Response();
        $newHandlers = ob_list_handlers();

        $this->assertEquals(count($originalHandlers) + 1, count($newHandlers));

        $response->addHeader('X-SPIL-Test: True');
        $response->registerOutputBufferCallback(array('SPIL_HTTP_Server_Response_Test', 'obCallback'));

        $originalHeaders = headers_list();
        $originalCount = SPIL_HTTP_Server_Response_Test::$count;
        SPIL_HTTP_Server_Response::handleFlush('');
        $newHeaders = headers_list();
        $newCount = SPIL_HTTP_Server_Response_Test::$count;
        $this->assertEquals(count($originalHeaders) + 1, count($newHeaders));
        $this->assertEquals($originalCount + 1, $newCount);
    }
}

if (__FILE__ == $_SERVER['SCRIPT_FILENAME'])
{
    $test = new SPIL_HTTP_Server_Response_Test();
    $test->testOutputBuffer();
    echo "<div>" . $test->failedCount . " assertions failed out of " . $test->assertCount . " total.</div>";
}