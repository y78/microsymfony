<?php

namespace Yarik\MicroSymfony\Component\Cache\Coder;

class KernelCoder
{
    public function getCode($config, $routing, $mapping)
    {
        return '
            namespace Cache;
        
            use Yarik\MicroSymfony\ODM\Persistence\DocumentManagerCachedFactory;
            use Yarik\MicroSymfony\Component\HttpFoundation\Factory\CachedRouterFactory;
            use Yarik\MicroSymfony\Component\HttpFoundation\Request;
            use Yarik\MicroSymfony\Component\HttpFoundation\Response;
            
            class CacheKernel extends \Yarik\MicroSymfony\Component\HttpKernel\Kernel
            {
                protected function initConfig()
                {
                    if ($this->env) {
                        $this->configPath = $this->rootDir . \'/config/\' . $this->env . \'.yml\';
                    } else {
                        $this->configPath = $this->rootDir . \'/config/config.yml\';
                    }
            
                    $this->config = ' . $config . ';
                }
                
                
                /** @return Response */
                public function handleRequest(Request $request)
                {
                    $this->container->set(\'request\', $request);
                    
                    $dmFactory = new DocumentManagerCachedFactory(' . $mapping . ');
                    $this->container->set(\'mongo.manager.factory\', $dmFactory);
                    
            
                    $factory = new CachedRouterFactory(' . $routing . ');
                    
                    $router = $factory->createRouter($request);
                    $this->container->set(\'router\', $router);
                    
                    $route = $router->getRoute();
                    $controller = $route->get(\'_controller\');
                    preg_match(\'/^(.*?)\:(.*?)\:(.*?)$/\', $controller, $matches);
                    $class = $matches[1] . \'\\\\Controller\\\\\' . $matches[2] . \'Controller\';
                    $instance = new $class($this->container);
            
                    return $this->callMethodArray(
                        $instance,
                        $matches[3] . \'Action\',
                        $route->parameters->all() + [\'request\' => $request]
                    );
                }
            }
        ';
    }
}