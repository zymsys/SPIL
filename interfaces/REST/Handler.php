<?php

/**
 * Handle REST style requests
 */
interface ISPIL_REST_Handler
{
    /**
     * This is the main "worker" method which is called to handle the request.
     * @abstract
     */
    public function handleRequest();

    /**
     * Sets the output data mapper for this handler.
     * This is the mapper that is used to map the response data to an output format
     * such as JSON or XML.
     * @abstract
     * @param null $mapper ISPIL_DataMapper_Base
     */
    public function setMapper($mapper = null);

    /**
     * Sets the output data mapper for this handler.
     * This is the mapper that is used to map the response data to an output format
     * such as JSON or XML.
     * @abstract
     * @return ISPIL_DataMapper_Base
     */
    public function getMapper();
}