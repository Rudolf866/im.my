<?php


namespace core\base\exceptions;


use core\base\controller\BaseMethods;


class RouteException extends \Exception
{
    protected $messages;

    use BaseMethods;

    public function __construct($message = "", $code = 0)
    {
        parent::__construct($message, $code);

        $this->messages = include 'messages.php';

        $error = $this->getMessage() ? $this->getMessage() : $this->messages[$this->getCode()];

        $error .="\r\n" . 'file ' . $this->getFile() . "\r\n" . 'In Line ' . $this->getLine() . "\r\n";

       // if($this->messages[$this->getCode()]) $this->messages = $this->messages[$this->getCode()];

        $this->writeLog($error);
    }

}