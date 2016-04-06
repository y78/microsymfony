<?php

namespace App\Main\Document;

class Doc implements \JsonSerializable
{
    protected $id;
    protected $name;
    protected $embed;

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    public function __construct()
    {
        $this->embed = new DocEmbed();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getEmbed()
    {
        return $this->embed;
    }

    public function setEmbed($embed)
    {
        $this->embed = $embed;
        return $this;
    }
}