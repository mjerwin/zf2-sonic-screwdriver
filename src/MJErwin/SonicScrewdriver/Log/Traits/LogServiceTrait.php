<?php

namespace MJErwin\SonicScrewdriver\Log\Traits;

use MJErwin\SonicScrewdriver\Log\Service\LogService;

/**
 * @author Matthew Erwin <matthew.j.erwin@me.com>
 * www.matthewerwin.co.uk
 */
trait LogServiceTrait
{
    /** @var LogService */
    protected $log_service;

    /**
     * @return LogService
     */
    public function getLogService()
    {
        if (!$this->log_service)
        {
            $this->log_service = $this->getRootServiceLocator()->get(LogService::class);
        }

        return $this->log_service;
    }
} 