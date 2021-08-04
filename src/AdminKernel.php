<?php

namespace App;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class AdminKernel extends Kernel
{
    protected function configureContainer(ContainerConfigurator $container): void
    {
        parent::configureContainer($container);

        $this->relativeConfigureContainer($container, 'apps/admin/');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        parent::configureRoutes($routes);

        $this->relativeConfigureRoutes($routes, 'apps/admin/');
    }

    public function getCacheDir(): string
    {
        return $this->getProjectDir().'/var/admin/cache/'.$this->environment;
    }

    public function getLogDir(): string
    {
        return $this->getProjectDir().'/var/admin/log';
    }
}
