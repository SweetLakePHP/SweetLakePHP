<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    protected $developmentEnvironments = array('dev', 'test');

    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new SWP\FrontendBundle\SWPFrontendBundle(),
            new Gregwar\CaptchaBundle\GregwarCaptchaBundle(),
            new DMS\Bundle\MeetupApiBundle\DMSMeetupApiBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new SWP\BackendBundle\SWPBackendBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
        );

        if (in_array($this->getEnvironment(), $this->developmentEnvironments)) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_' . $this->getEnvironment() . '.yml');
    }

    /**
     * Override the cache dir for Vagrant
     */
    public function getCacheDir()
    {
        if (in_array($this->getEnvironment(), $this->developmentEnvironments)) {
            return '/dev/shm/' . basename(dirname(__DIR__)) . '/cache/' . $this->environment;
        }

        return parent::getCacheDir();
    }

    /**
     * Override the logs dir for Vagrant
     */
    public function getLogDir()
    {
        if (in_array($this->getEnvironment(), $this->developmentEnvironments)) {
            return '/dev/shm/' . basename(dirname(__DIR__)) . '/log/' . $this->environment;
        }

        return parent::getLogDir();
    }
}
