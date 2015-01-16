<?php

namespace MJErwin\SonicScrewdriver\Doctrine\Validator;

use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;
use Zend\Validator\ValidatorInterface;

/**
 * @author Matthew Erwin <matthew.j.erwin@me.com>
 * www.matthewerwin.co.uk
 */
class IsUnique extends AbstractValidator implements ValidatorInterface
{
    protected $object_repository;
    protected $fields = [];
    protected $object_manager;

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param  mixed $value
     *
     * @return bool
     * @throws Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($value)
    {
        $object_repository = $this->getOption('object_repository');
        echo get_class($object_repository);
        die;
    }

} 