<?php

/**
 * Handles HTTP response mechanics such as output buffering and headers.
 */
class SPIL_HTTP_Server_Response implements ISPIL_HTTP_Server_Response
{
    private static $_ob_callbacks = array();
    private static $_headers = array();

    public function __construct()
    {
        if (!ob_start(array('SPIL_HTTP_Server_Response', 'handleFlush')))
        {
            throw new ErrorException("Can't start output buffering");
        }
    }

    /**
     * Output callback which invokes the other registered output buffer callbacks
     * and adds added headers.
     * @param $buffer string
     */
    public function handleFlush($buffer)
    {
        foreach (SPIL_HTTP_Server_Response::$_headers as $header)
        {
            header($header);
        }
        foreach (SPIL_HTTP_Server_Response::$_ob_callbacks as $callback)
        {
            $buffer = call_user_func($callback, $buffer);
        }

        return $buffer;
    }

    /**
     * Registers an output callback which gets invoked when the output buffer is flushed.
     * @param $callback
     */
    public function registerOutputBufferCallback($callback)
    {
        SPIL_HTTP_Server_Response::$_ob_callbacks[] = $callback;
    }

    /**
     * Adds a header to the HTTP response.
     * @param $header string
     */
    public function addHeader($header)
    {
        SPIL_HTTP_Server_Response::$_headers[] = $header;
    }
}