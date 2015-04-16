<?php

namespace MJErwin\SonicScrewdriver\Log\Service;

use MJErwin\SonicScrewdriver\ServiceLocator\Traits\ServiceLocatorAwareTrait;
use Monolog\Handler\NativeMailerHandler;
use Monolog\Handler\RollbarHandler;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use RollbarNotifier;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Environment\Service\EnvironmentService;

/**
 * @author Matthew Erwin <matthew.j.erwin@me.com>
 * www.matthewerwin.co.uk
 */
class LogService implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /** @var  Logger */
    protected $general_logger;

    /** @var  EnvironmentService */
    protected $environment_service;

    function __construct()
    {
//        require_once '/vendor/rollbar.php';
    }

    /**
     * @return Logger
     */
    public function getGeneralLogger()
    {
        if (!$this->general_logger)
        {
            $this->general_logger = new Logger('general');
            $this->general_logger->pushHandler(new StreamHandler('data/logs/general.log'));
            $this->general_logger->pushHandler(new NativeMailerHandler('', 'Error', LOG_EMAIL, Logger::ERROR));
            $this->general_logger->pushHandler(new RollbarHandler(new RollbarNotifier([
                'access_token' =>'',
                'environment' => $this->getEnvironmentName(),
            ]), Logger::WARNING));
        }

        return $this->general_logger;
    }

    /**
     * @return EnvironmentService
     */
    public function getEnvironmentService()
    {
        if (!$this->environment_service instanceof EnvironmentService)
        {
            $this->environment_service = $this->getServiceLocator()->get(EnvironmentService::class);
        }

        return $this->environment_service;
    }

    public function getEnvironmentName()
    {
        try
        {
            $name = $this->getEnvironmentService()->getCurrentEnvironment()->getName();
        }
        catch(\Exception $e)
        {
            $name = 'Unknown';
        }

        return $name;
    }
} 
