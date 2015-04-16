<?php

namespace MJErwin\SonicScrewdriver\Doctrine\Validator;

use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;
use Zend\Validator\ValidatorInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

/**
 * @author Matthew Erwin <matthew.j.erwin@me.com>
 * www.matthewerwin.co.uk
 */
class IsUnique extends AbstractValidator implements ValidatorInterface
{
    const ERROR_NOT_UNIQUE = 'notUnique';

    /** @var EntityRepository */
    protected $object_repository;
    /** @var array */
    protected $fields = [];
    /** @var  EntityManager */
    protected $object_manager;

    protected $messageTemplates = [
        self::ERROR_NOT_UNIQUE => 'The object is not unique',
    ];

    function __construct(array $options)
    {
        // Object Repository
        $object_repository = isset($options['object_repository']) ? $options['object_repository'] : null;

        if (!$object_repository instanceof EntityRepository)
        {
            throw new \Exception(self::class . ' Option `object_repository` must be an instance of ' . EntityRepository::class);
        }

        $this->setObjectRepository($object_repository);

        // Object Manager
        $object_manager = isset($options['object_manager']) ? $options['object_manager'] : null;

        if (!$object_manager instanceof EntityManager)
        {
            throw new \Exception(self::class . ' Option `object_manager` must be an instance of ' . EntityManager::class);
        }

        $this->setObjectManager($object_manager);

        $fields = isset($options['fields']) ? $options['fields'] : null;

        if (!is_array($fields) || empty($fields))
        {
            throw new \Exception(self::class . ' Option `fields` must be an array with at least one value');
        }

        $this->setFields($fields);
    }


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
        $this->error(self::ERROR_NOT_UNIQUE);

        return false;
    }

    /**
     * @return EntityRepository
     */
    public function getObjectRepository()
    {
        return $this->object_repository;
    }

    /**
     * @param EntityRepository $object_repository
     */
    public function setObjectRepository(EntityRepository $object_repository)
    {
        $this->object_repository = $object_repository;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return EntityManager
     */
    public function getObjectManager()
    {
        return $this->object_manager;
    }

    /**
     * @param EntityManager $object_manager
     */
    public function setObjectManager(EntityManager $object_manager)
    {
        $this->object_manager = $object_manager;
    }


}