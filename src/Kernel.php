<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $this->relativeConfigureContainer($container);
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $this->relativeConfigureRoutes($routes);
    }

    protected function relativeConfigureContainer(ContainerConfigurator $container, string $path = ''): void
    {
        $container->import('../config/'.$path.'{packages}/*.yaml');
        $container->import('../config/'.$path.'{packages}/'.$this->environment.'/*.yaml');

        if (is_file(\dirname(__DIR__).'/config/'.$path.'services.yaml')) {
            $container->import('../config/'.$path.'services.yaml');
            $container->import('../config/'.$path.'{services}_'.$this->environment.'.yaml');
        } else {
            $container->import('../config/'.$path.'{services}.php');
        }
    }

    protected function relativeConfigureRoutes(RoutingConfigurator $routes, string $path = ''): void
    {
        $routes->import('../config/'.$path.'{routes}/'.$this->environment.'/*.yaml');
        $routes->import('../config/'.$path.'{routes}/*.yaml');

        if (is_file(\dirname(__DIR__).'/config/'.$path.'routes.yaml')) {
            $routes->import('../config/'.$path.'routes.yaml');
        } else {
            $routes->import('../config/'.$path.'{routes}.php');
        }
    }
}
