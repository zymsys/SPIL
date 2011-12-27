<?php

class SPIL_REST_Handler
{
    protected $_responseData;
    protected $_response;
    protected $_request;
    protected $_mapper;

    public function __construct()
    {
        $this->_responseData = new stdClass();
    }

    protected function getRequest()
    {
        if (!isset($this->_request))
        {
            $this->_request = new SPIL_HTTP_Server_Request();
        }
        return $this->_request;
    }

    protected function getResponse()
    {
        if (!isset($this->_response))
        {
            $this->_response = new SPIL_HTTP_Server_Response();
        }
        return $this->_response;
    }

    public function handleRequest()
    {
        $method = strtolower($this->getRequest()->getMethod());
        if (method_exists($this, $method))
        {
            try
            {
                call_user_func(array($this, $method));
            }
            catch (ErrorException $e)
            {
                $this->getResponse()->addHeader($this->getRequest()->getProtocol() . ' ' . $e->getCode());
                $this->_responseData->status = 'error';
                $this->_responseData->message = $e->getMessage();
            }
        }
        $this->getResponse()->addHeader('Content-type: ' . $this->getMapper()->getContentType());
        echo $this->getMapper()->output($this->_responseData);
    }

    public function setMapper($mapper = null)
    {
        if (is_null($mapper))
        {
            $mapper = new SPIL_DataMapper_JSON();
        }
        $this->_mapper = $mapper;
    }

    public function getMapper()
    {
        if (!isset($this->_mapper))
        {
            $this->setMapper();
        }
        return $this->_mapper;
    }
}