<?php

/**
 * Represents the information a PHP script has about the HTTP request which generated it.
 */
interface ISPIL_HTTP_Server_Request
{
    /**
     * Returns the HTTP method used to make the request (GET, POST, PUT, DELETE, etc)
     * @return string
     */
    public function getMethod();

    /**
     * Set the path of the request.  This is the 'folder' name of the requested item.
     * Setting this value to null requests that it be set automatically.
     * @param null $newPath string
     */
    public function setPath($newPath = null);

    /**
     * Get the path of the request.  This is the 'folder' name of the requested item.
     * @return string
     */
    public function getPath();

    /**
     * Set the 'inside' path of the request.  This is the path which comes after the script name:
     * http://example.com/regular/path/script.php/inside/path
     * Setting this value to null requests that it be set automatically.
     * @param null $newInsidePath string
     */
    public function setInsidePath($newInsidePath = null);

    /**
     * Get the 'inside' path of the request.  This is the path which comes after the script name:
     * http://example.com/regular/path/script.php/inside/path
     * @return string
     */
    public function getInsidePath();

    /**
     * Set the protocol for the request such as 'HTTP/1.1'
     * @param null $newProtocol string
     */
    public function setProtocol($newProtocol = null);

    /**
     * Get the protocol for the request such as 'HTTP/1.1'
     * @return string
     */
    public function getProtocol();
}