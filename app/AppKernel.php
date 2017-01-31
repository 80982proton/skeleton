<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            // $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            // $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return PIMCORE_WEBSITE_PATH;
    }

    public function getCacheDir()
    {
        return PIMCORE_CACHE_DIRECTORY . '/symfony/' . $this->getEnvironment();
    }

    public function getLogDir()
    {
        return PIMCORE_LOG_DIRECTORY . '/symfony';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/var/config/symfony/config_' . $this->getEnvironment() . '.yml');
    }
}
