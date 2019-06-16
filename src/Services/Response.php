<?php

namespace Bicycle\Services;

class Response
{
    private $headers;
    private $outputString;

    public function __construct()
    {
        $this->headers = [];
    }

    public function setHeader(string $header)
    {
        $this->headers[] = $header;
    }

    public function setOutput(string $string)
    {
        $this->outputString = $string;
    }

    public function sendHeaders()
    {
        if (count($this->headers)) {
            foreach ($this->headers as $header) {
                header($header);
            }
        }
    }

    public function setResponseCode(int $code = 200)
    {
        http_response_code($code);
    }

    public function output()
    {
        echo $this->outputString;
    }
}