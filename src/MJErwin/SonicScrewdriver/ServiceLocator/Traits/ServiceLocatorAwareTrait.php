<?php

namespace MJErwin\SonicScrewdriver\ServiceLocator\Traits;

use Zend\Form\FormElementManager;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\View\HelperPluginManager;

/**
 * @author Matthew Erwin <matthew.j.erwin@me.com>
 * www.matthewerwin.co.uk
 */
trait ServiceLocatorAwareTrait
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $service_locator = null;

    protected $root_service_locator = null;

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->service_locator = $serviceLocator;

        return $this;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->service_locator;
    }

    /**
     * @param ServiceLocatorInterface $rootServiceLocator
     */
    public function setRootServiceLocator(ServiceLocatorInterface $rootServiceLocator)
    {
        $this->root_service_locator = $rootServiceLocator;
    }

    /**
     * @return ServiceManager
     * @throws \Exception
     */
    public function getRootServiceLocator()
    {
        if (!$this->root_service_locator)
        {
            if($this->getServiceLocator() instanceof ServiceManager)
            {
                $this->setRootServiceLocator($this->getServiceLocator());
            }

            if ($this->getServiceLocator() instanceof FormElementManager || $this->getServiceLocator() instanceof HelperPluginManager)
            {
                $this->setRootServiceLocator($this->getServiceLocator()->getServiceLocator());
            }
            else
            {
                if($this->getServiceLocator() === null)
                {
                    throw new \Exception('wtf!');
                }
                $this->setRootServiceLocator($this->getServiceLocator());
            }
        }

        return $this->root_service_locator;
    }
} 