<?php

namespace Yarik\MicroSymfony\Component\HttpFoundation;

class Response
{
    protected $content = '';
    protected $headers = [
        'Content-Type' => 'UTF-8'
    ];

    public function __construct($content = '')
    {
        $this->content = $content;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function handle()
    {
    }
    
    public function sendHeaders()
    {
        if (headers_sent()) {
            return $this;
        }

        foreach ($this->headers as $name => $value) {
            header($name . ':' . $value);
        }

        return $this;
    }

    public function sendContent()
    {
        echo $this->content;

        return $this;
    }

    public function send()
    {
        return $this
            ->sendHeaders()
            ->sendContent()
        ;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function hasHeader($key)
    {
        return isset($this->headers[$key]);
    }

    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function removeHeader($key)
    {
        unset($this->headers[$key]);
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }
}