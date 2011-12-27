<?php

/**
 * Handles HTTP response mechanics such as output buffering and headers.
 */
interface ISPIL_HTTP_Server_Response
{
    /**
     * Output callback which invokes the other registered output buffer callbacks
     * and adds added headers.
     * @abstract
     * @param $buffer string
     */
    public function handleFlush($buffer);

    /**
     * Registers an output callback which gets invoked when the output buffer is flushed.
     * @abstract
     * @param $callback
     */
    public function registerOutputBufferCallback($callback);

    /**
     * Adds a header to the HTTP response.
     * @abstract
     * @param $header string
     */
    public function addHeader($header);
}