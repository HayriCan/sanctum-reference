<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    public $data;
    public $message;
    public $code;

    public function __construct($data, $message = NULL, $code = NULL, Exception $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
        $this->message = $message;
        $this->data = $data;
        $this->code = $code;
    }

    public function render()
    {
        return response()->json([
            "error"=>true,
            "message" => $this->message,
            'data' => $this->data
        ],$this->code);
    }
}
