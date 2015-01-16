<?php

namespace MJErwin\SonicScrewdriver\Doctrine\Traits;

use Doctrine\ORM\EntityManager;


/**
 * @author Matthew Erwin <matthew.j.erwin@me.com>
 * www.matthewerwin.co.uk
 */
trait EntityManagerAwareTrait
{
    protected $em;

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        if (!$this->em)
        {
            $this->em = $this->getRootServiceLocator()->get(EntityManager::class);
        }

        return $this->em;
    }
} 