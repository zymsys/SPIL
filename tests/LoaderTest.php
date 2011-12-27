<?php

require_once('SPIL/Loader.php');

class SPIL_Loader_Test extends PHPUnit_Framework_TestCase
{
    public function testDefaultClassPath()
    {
        $path = SPIL_Loader::getClassPath();
        $this->assertTrue(file_exists($path . '/HTTP/Server/Request.php'));
    }

    public function testDontLoadNonSPIL()
    {
        $path = SPIL_Loader::getPath('DoesNotExist');
        $this->assertFalse($path, "Doesn't try to load non-SPIL classes");
    }

    public function testRegisterRepository()
    {
        $testRepo = 'file://classes';
        SPIL_Loader::registerRepository($testRepo);
        $repos = SPIL_Loader::getRepositories();
        $this->assertTrue(array_search($testRepo, $repos) !== false,
            "Registered repositories are stored and returned by getRepositories.");
    }

    public function testSetPaths()
    {
        $originalClassPath = SPIL_Loader::getClassPath();
        $parts = explode(DIRECTORY_SEPARATOR, __DIR__);
        array_pop($parts);
        $testpath = implode(DIRECTORY_SEPARATOR, $parts) . DIRECTORY_SEPARATOR . 'dummy' .
            DIRECTORY_SEPARATOR;
        $testclasspath = $testpath . 'classes';
        SPIL_Loader::setClassPath($testclasspath);
        $classresult = SPIL_Loader::getClassPath();
        $this->assertEquals($testclasspath, $classresult,
            "SPIL_Loader::setClassPath sets a new class path.");
        $testinterfacepath = $testpath . 'interfaces';
        SPIL_Loader::setInterfacePath($testinterfacepath);
        $interfaceresult = SPIL_Loader::getInterfacePath();
        $this->assertEquals($testinterfacepath, $interfaceresult,
            "SPIL_Loader::setInterfacePath sets a new interface path.");
        SPIL_Loader::setClassPath($originalClassPath);
    }

    public function testManualLoad()
    {
        $originalClassPath = SPIL_Loader::getClassPath();
        $parts = explode(DIRECTORY_SEPARATOR, __DIR__);
        array_pop($parts);
        $testpath = implode(DIRECTORY_SEPARATOR, $parts) . DIRECTORY_SEPARATOR . 'dummy' .
            DIRECTORY_SEPARATOR;
        $testclasspath = $testpath . 'classes';
        SPIL_Loader::setClassPath($testclasspath);
        $testClass = 'SPIL_Nothing';
        $testInstance = 'I' . $testClass;
        SPIL_Loader::load($testClass);
        $this->assertTrue(class_exists($testClass),
            "SPIL_Loader::load successfully loads classes.");
        $this->assertTrue(interface_exists($testInstance),
                    "SPIL_Loader::load successfully loads interfaces.");
        SPIL_Loader::setClassPath($originalClassPath);
    }

    public function testAutoLoad()
    {
        $originalClassPath = SPIL_Loader::getClassPath();
        $parts = explode(DIRECTORY_SEPARATOR, __DIR__);
        array_pop($parts);
        $testpath = implode(DIRECTORY_SEPARATOR, $parts) . DIRECTORY_SEPARATOR . 'dummy' .
            DIRECTORY_SEPARATOR;
        $testclasspath = $testpath . 'classes';
        SPIL_Loader::setClassPath($testclasspath);
        $testClass = 'SPIL_Nothing2';
        $nothing = new $testClass();
        $this->assertTrue($nothing instanceof SPIL_Nothing2,
            "Autoloader successfully loads classes.");
        SPIL_Loader::setClassPath($originalClassPath);
    }
}