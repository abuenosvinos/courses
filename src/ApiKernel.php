<?php

namespace App;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class ApiKernel extends Kernel
{
    protected function configureContainer(ContainerConfigurator $container): void
    {
        parent::configureContainer($container);

        $container->import('../config/api/{packages}/*.yaml');
        $container->import('../config/api/{packages}/'.$this->environment.'/*.yaml');

        if (is_file(\dirname(__DIR__).'/config/api/services.yaml')) {
            $container->import('../config/api/services.yaml');
            $container->import('../config/api/{services}_'.$this->environment.'.yaml');
        } else {
            $container->import('../config/api/{services}.php');
        }
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        parent::configureRoutes($routes);

        $routes->import('../config/api/{routes}/'.$this->environment.'/*.yaml');
        $routes->import('../config/api/{routes}/*.yaml');

        if (is_file(\dirname(__DIR__).'/config/api/routes.yaml')) {
            $routes->import('../config/api/routes.yaml');
        } else {
            $routes->import('../config/api/{routes}.php');
        }
    }

    public function getCacheDir(): string
    {
        return $this->getProjectDir().'/var/api/cache/'.$this->environment;
    }

    public function getLogDir(): string
    {
        return $this->getProjectDir().'/var/api/log';
    }
}
