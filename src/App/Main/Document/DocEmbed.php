<?php

namespace App\Main\Document;

class DocEmbed
{
    protected $key1;
    protected $key2;

    public function getKey1()
    {
        return $this->key1;
    }

    public function setKey1($key1)
    {
        $this->key1 = $key1;
        return $this;
    }

    public function getKey2()
    {
        return $this->key2;
    }

    public function setKey2($key2)
    {
        $this->key2 = $key2;
        return $this;
    }
}