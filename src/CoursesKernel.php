<?php

namespace App;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class CoursesKernel extends Kernel
{
    protected function configureContainer(ContainerConfigurator $container): void
    {
        parent::configureContainer($container);

        $this->relativeConfigureContainer($container, 'courses/');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        parent::configureRoutes($routes);

        $this->relativeConfigureRoutes($routes, 'courses/');
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
