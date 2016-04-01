<?php

class CacheKernel extends \Yarik\MicroSymfony\Component\HttpKernel\Kernel
{
    protected function initConfig()
    {
        if ($this->env) {
            $this->configPath = $this->rootDir . '/config/' . $this->env . '.yml';
        } else {
            $this->configPath = $this->rootDir . '/config/config.yml';
        }

        $this->config = $config;
    }
}