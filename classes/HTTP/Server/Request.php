<?php

/**
 * Represents the information a PHP script has about the HTTP request which generated it.
 */
class SPIL_HTTP_Server_Request implements ISPIL_HTTP_Server_Request
{
    /**
     * @var string Path to requested resource
     */
    protected $_path;
    /**
     * @var string File name of requested resource
     */
    protected $_fileName;
    /**
     * @var string File extension of requested resource
     */
    protected $_extensionName;
    /**
     * @var string Path which comes after the file name, but before a query string
     */
    protected $_insidePath;
    /**
     * @var string Query string of requested resource
     */
    protected $_queryString;
    /**
     * @var string Protocol of HTTP request such as HTTP/1.1
     */
    protected $_protocol;

    /**
     * Returns the HTTP method used to make the request (GET, POST, PUT, DELETE, etc)
     * @abstract
     * @return string
     */
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Worker behind the other setters when passed a null value.
     * Tries to figure out the best values for all unknown items and fills them in.
     */
    private function setInfo()
    {
        $this->_insidePath = is_null($this->_insidePath) && array_key_exists('PATH_INFO', $_SERVER) ?
            $_SERVER['PATH_INFO'] : $this->_insidePath;
        $this->_queryString = is_null($this->_queryString) && array_key_exists('QUERY_STRING', $_SERVER) ?
            $_SERVER['QUERY_STRING'] : $this->_queryString;
        $this->_protocol = is_null($this->_protocol) && array_key_exists('SERVER_PROTOCOL', $_SERVER) ?
            $_SERVER['SERVER_PROTOCOL'] : $this->_protocol;
        $key = 'SCRIPT_NAME';
        if (!array_key_exists($key, $_SERVER))
        {
            return; //No path info to get!
        }
        $info = pathinfo($_SERVER[$key]);
        $this->_path = is_null($this->_path) ? $info['dirname'] : $this->_path;
        $this->_fileName = is_null($this->_fileName) ? $info['basename'] : $this->_fileName;
        $this->_extensionName = is_null($this->_extensionName) ? $info['extension'] : $this->_extensionName;
    }

    /**
     * Set the path of the request.  This is the 'folder' name of the requested item.
     * Setting this value to null requests that it be set automatically.
     * @abstract
     * @param null $newPath string
     */
    public function setPath($newPath = null)
    {
        if (is_null($newPath))
        {
            $this->setInfo();
        }
        else
        {
            $this->_path = $newPath;
        }
    }

    /**
     * Get the path of the request.  This is the 'folder' name of the requested item.
     * @abstract
     * @return string
     */
    public function getPath()
    {
        if (!isset($this->_path))
        {
            $this->setPath();
        }
        return $this->_path;
    }

    /**
     * Set the 'inside' path of the request.  This is the path which comes after the script name:
     * http://example.com/regular/path/script.php/inside/path
     * Setting this value to null requests that it be set automatically.
     * @abstract
     * @param null $newInsidePath string
     */
    public function setInsidePath($newInsidePath = null)
    {
        if (is_null($newInsidePath))
        {
            $this->setInfo();
        }
        else
        {
            $this->_insidePath = $newInsidePath;
        }
    }

    /**
     * Get the 'inside' path of the request.  This is the path which comes after the script name:
     * http://example.com/regular/path/script.php/inside/path
     * @abstract
     * @return string
     */
    public function getInsidePath()
    {
        if (!isset($this->_insidePath))
        {
            $this->setInfo();
        }
        return $this->_insidePath;
    }

    /**
      * Set the protocol for the request such as 'HTTP/1.1'
      * @abstract
      * @param null $newProtocol string
      */
    public function setProtocol($newProtocol = null)
    {
        if (is_null($newProtocol))
        {
            $this->setInfo();
        }
        else
        {
            $this->_protocol = $newProtocol;
        }
    }

    /**
     * Get the protocol for the request such as 'HTTP/1.1'
     * @abstract
     * @return string
     */
    public function getProtocol()
    {
        if (!isset($this->_protocol))
        {
            $this->setProtocol();
        }
        return $this->_protocol;
    }
}