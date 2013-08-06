<?php
namespace application\models;

class ValidationError
{
    /**
     * @var string
     */
    private $_message;

    /**
     * @param $errorMessage
     */
    public function __construct($errorMessage)
    {
        $this->_message = $errorMessage;
    }

    /**
     * returns error message
     * @return string
     */
    public function getMessage()
    {
        return $this->_message;
    }

    public function __toString()
    {
        return (string)$this->_message;
    }
}