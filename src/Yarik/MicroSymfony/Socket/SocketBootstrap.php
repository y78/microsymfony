<?php

namespace Yarik\MicroSymfony\Socket;

class SocketBootstrap
{
    protected $version = '1.0-beta3';

    public function boot($command, $appClass = null, $config = null)
    {
        @ob_end_clean();
        error_reporting(E_ALL);

        $this->fixMagic();

        $phpDaemonPath = dirname(dirname($this->getDaemonCorePath()));
        $config .= 'path ' . $phpDaemonPath . '/conf/AppResolver.php;' . "\n";
        if (null !== $appClass) {
            $appClass = '\\' . ltrim($appClass, '\\');
            $config .= $appClass . " {} \n";
        }

        $path = $this->getAsFilePath($config);
        $argv = $_SERVER['argv'];
        $_SERVER['argv'] = [null, $command];
        $e = null;
        execute:
        try {
            if ($e) {
                $thread = $e->getThread();
                $e      = null;
                $thread();
            }
            else {
                \PHPDaemon\Core\Bootstrap::init($path);
            }
        } catch (\PHPDaemon\Exceptions\ClearStack $e) {
            goto execute;
        }

        $_SERVER['argv'] = $argv;
    }

    public function fixMagic()
    {
        $brokenFilePath = $this->getDaemonCorePath() . '/Daemon.php';
        $content = file_get_contents($brokenFilePath);
        $content = str_replace('file_get_contents(\'VERSION\', true)', '\'' . $this->version . '\'', $content);

        require_once self::getAsFilePath($content);
    }

    protected function getDaemonCorePath()
    {
        $r = new \ReflectionClass(\PHPDaemon\Core\AppInstance::class);
        return dirname($r->getFileName());
    }

    protected function getAsFilePath($content)
    {
        $tmp = fopen('tmp.conf', 'w+');
        fwrite($tmp, $content);
        $path = stream_get_meta_data($tmp)['uri'];
        fclose($tmp);

        return $path;
    }
}
