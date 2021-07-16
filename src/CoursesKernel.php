<?php

namespace App;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class CoursesKernel extends Kernel
{
    protected function configureContainer(ContainerConfigurator $container): void
    {
        parent::configureContainer($container);

        $container->import('../config/courses/{packages}/*.yaml');
        $container->import('../config/courses/{packages}/'.$this->environment.'/*.yaml');

        if (is_file(\dirname(__DIR__).'/config/courses/services.yaml')) {
            $container->import('../config/courses/services.yaml');
            $container->import('../config/courses/{services}_'.$this->environment.'.yaml');
        } else {
            $container->import('../config/courses/{services}.php');
        }
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        parent::configureRoutes($routes);

        $routes->import('../config/courses/{routes}/'.$this->environment.'/*.yaml');
        $routes->import('../config/courses/{routes}/*.yaml');

        if (is_file(\dirname(__DIR__).'/config/courses/routes.yaml')) {
            $routes->import('../config/courses/routes.yaml');
        } else {
            $routes->import('../config/courses/{routes}.php');
        }
    }

    public function getCacheDir(): string
    {
        return $this->getProjectDir().'/var/courses/cache/'.$this->environment;
    }

    public function getLogDir(): string
    {
        return $this->getProjectDir().'/var/courses/log';
    }
}
