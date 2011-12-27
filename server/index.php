<?php
/*
 The index.php script in the server folder provides the repository script.  It is
 fairly straight forward.  After you've installed SPIL you can put this script
 anywhere on the server with SPIL, and it can be used to serve up the SPIL classes
 and interfaces known to that server.
 */

require_once('SPIL/Loader.php');

class SPILCore_Repository_Handler extends SPIL_REST_Handler
{
    public function get()
    {
        $resourcePath = $this->getRequest()->getInsidePath();
        $resourceParts = explode('/', $resourcePath);
        array_shift($resourceParts); //Discard leading /
        $className = array_shift($resourceParts);
        $phpVersion = array_shift($resourceParts);
        $requiredMethods = $resourceParts;
        $phpVersionMethod = 'getSupportedPhpVersion';
        if (!class_exists($className))
        {
            throw new ErrorException("$className not found.", 404);
        }
        if (method_exists($className, $phpVersionMethod))
        {
            $supportedVersion = call_user_func(array($className, $phpVersionMethod));
            if (version_compare($supportedVersion, $phpVersion) >= 0)
            {
                throw new ErrorException("$className does not support PHP version $phpVersion.  ".
                    "It requires at least $supportedVersion.", 501);
            }
        }
        foreach ($requiredMethods as $method) {
            if (!method_exists($className, $method))
            {
                throw new ErrorException("$method not implemented by this $className.", 501);
            }
        }

        $this->_responseData->classSource = file_get_contents(SPIL_Loader::getPath($className));
        $interfacePath = SPIL_Loader::getPath('I' . $className);
        if (file_exists($interfacePath))
        {
            $this->_responseData->interfaceSource = file_get_contents($interfacePath);
        }
    }
}

$restHandler = new SPILCore_Repository_Handler();
$restHandler->handleRequest();