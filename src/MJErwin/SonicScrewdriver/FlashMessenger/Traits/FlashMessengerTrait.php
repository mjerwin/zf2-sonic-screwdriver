<?php

namespace MJErwin\SonicScrewdriver\FlashMessenger\Traits;

use Zend\Mvc\Controller\Plugin\FlashMessenger;


/**
 * @author Matthew Erwin <matthew.j.erwin@me.com>
 * www.matthewerwin.co.uk
 */
trait FlashMessengerTrait
{
    /** @var FlashMessenger|null */
    protected $flash_messenger;

    /**
     * @return FlashMessenger
     */
    public function flashMessenger()
    {
        if (!$this->flash_messenger instanceof FlashMessenger)
        {
            $this->flash_messenger = new FlashMessenger();
        }

        return $this->flash_messenger;
    }
} 