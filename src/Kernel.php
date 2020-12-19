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
        $projectDir = $this->getProjectDir();
        $container->import("$projectDir/config/{packages}/*.yaml");
        $container->import("$projectDir/config/{packages}/{$this->environment}/*.yaml");
        $container->import("$projectDir/config/services.yaml");
        $container->import("$projectDir/config/{services}_{$this->environment}.yaml");
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $projectDir = $this->getProjectDir();
        $routes->import("$projectDir/config/{routes}/{$this->environment}/*.yaml");
        $routes->import("$projectDir/config/{routes}/*.yaml");
        $routes->import("$projectDir/config/routes.yaml");
    }
}
