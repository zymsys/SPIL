<?php
require_once 'HTTP/Request2.php';

class SPIL_Loader
{
    private static $_repositories = array();
    private static $_classPath;
    private static $_interfacePath;

    public static function registerRepository($repo)
    {
        SPIL_Loader::$_repositories[] = $repo;
    }

    public static function getRepositories()
    {
        return SPIL_Loader::$_repositories;
    }

    private static function getExpectedPath($className)
    {
        $parts = explode('_',$className);
        $prefix = array_shift($parts);
        if ('SPIL' == $prefix)
        {
            $folder = SPIL_Loader::getClassPath();
        }
        elseif ('ISPIL' == $prefix)
        {
            $folder = SPIL_Loader::getInterfacePath();
        }
        else
        {
            return false;
        }
        array_unshift($parts, $folder);
        $path = implode(DIRECTORY_SEPARATOR, $parts) . '.php';
        return $path;
    }

    public static function getPath($className)
    {
        $path = SPIL_Loader::getExpectedPath($className);
        if ($path !== false)
        {
            if (!file_exists($path))
            {
                return SPIL_Loader::checkRepos($className, $path);
            }
        }
        return $path;
    }

    private static function checkRepos($className, $path)
    {
        $jsonMapper = new SPIL_DataMapper_JSON();
        foreach (SPIL_Loader::$_repositories as $repo)
        {
            $request = new HTTP_Request2($repo . '/' . $className . '/' . phpversion(),
                HTTP_Request2::METHOD_GET);
            $response = $request->send();
            if (200 == $response->getStatus())
            {
                $data = $jsonMapper->input($response->getBody());
                $name = $className;
                if ($name[0] == 'I')
                { //Make sure we load the class first
                    $name = substr($name, 1);
                }
                file_put_contents(SPIL_Loader::getExpectedPath($name), $data->classSource);
                if (isset($data->interfaceSource))
                {
                    file_put_contents(SPIL_Loader::getExpectedPath('I' . $name), $data->interfaceSource);
                }
                if (file_exists($path))
                {
                    return $path;
                }
            }
        }
        return false;
    }

    public static function load($className)
    {
        $path = SPIL_Loader::getPath($className);
        if ($path)
        {
            require_once($path);
        }
    }

    public static function getClassPath()
    {
        if (!isset(SPIL_Loader::$_classPath))
        {
            SPIL_Loader::$_classPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes';
        }
        return SPIL_Loader::$_classPath;
    }

    public static function setClassPath($classpath)
    {
        SPIL_Loader::$_classPath = $classpath;
    }

    public static function getInterfacePath()
    {
        if (!isset(SPIL_Loader::$_interfacePath))
        {
            SPIL_Loader::$_interfacePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'interfaces';
        }
        return SPIL_Loader::$_interfacePath;
    }

    public static function setInterfacePath($interfacepath)
    {
        SPIL_Loader::$_interfacePath = $interfacepath;
    }
}

if (function_exists('spl_autoload_register'))
{
    spl_autoload_register('SPIL_Loader::load');
}
else
{
    function __autoload($className)
    {
        SPIL_Loader::load($className);
    }
}