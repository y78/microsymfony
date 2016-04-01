<?php

namespace Yarik\MicroSymfony\Component\Cache\Coder;

class YamlCoder
{
    public function getCode(array $data)
    {
        return var_export($data, true);
    }
}