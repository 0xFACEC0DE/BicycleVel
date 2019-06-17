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
        return $this;
    }

    public function setOutput(string $string)
    {
        $this->outputString = $string;
        return $this;
    }

    public function sendHeaders()
    {
        if (count($this->headers)) {
            foreach ($this->headers as $header) {
                header($header);
            }
        }
        return $this;
    }

    public function setResponseCode(int $code = 200)
    {
        http_response_code($code);
        return $this;
    }

    public function output()
    {
        echo $this->outputString;
    }

    public function redirect(string $url = '/')
    {
        $this::setResponseCode(303);
        $this::setHeader('Location: ' . str_replace(['&amp;', "\n", "\r"], ['&', '', ''], $url));
        exit;
    }
}