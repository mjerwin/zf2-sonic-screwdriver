<?php

namespace MJErwin\SonicScrewdriver\Doctrine\Hydrator;

use Zend\Filter\FilterInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\Filter\Word\UnderscoreToCamelCase;

/**
 * @author Matthew Erwin <matthew.j.erwin@me.com>
 * www.matthewerwin.co.uk
 */
class DoctrineObject extends \DoctrineModule\Stdlib\Hydrator\DoctrineObject
{
    /** @var FilterInterface */
    protected $field_name_filter;

    /**
     * @param ObjectManager   $objectManager
     * @param FilterInterface $field_name_filter
     */
    public function __construct(ObjectManager $objectManager, FilterInterface $field_name_filter = null)
    {
        parent::__construct($objectManager, true);

        $this->setFieldNameFilter($field_name_filter);
    }

    /**
     * @return FilterInterface
     */
    public function getFieldNameFilter()
    {
        return $this->field_name_filter;
    }

    /**
     * @param FilterInterface $field_name_filter
     */
    public function setFieldNameFilter(FilterInterface $field_name_filter)
    {
        $this->field_name_filter = $field_name_filter;
    }


    /**
     * Hydrate the object using a by-value logic (this means that it uses the entity API, in this
     * case, setters)
     *
     * @param  array  $data
     * @param  object $object
     *
     * @throws RuntimeException
     * @return object
     */
    protected function hydrateByValue(array $data, $object)
    {
        $tryObject = $this->tryConvertArrayToObject($data, $object);
        $metadata = $this->metadata;

        if (is_object($tryObject))
        {
            $object = $tryObject;
        }

        foreach($data as $field => $value)
        {
            $value = $this->handleTypeConversions($value, $metadata->getTypeOfField($field));

            if ($this->getFieldNameFilter() instanceof FilterInterface)
            {
                $filter = new UnderscoreToCamelCase();
                $setter = 'set' . $filter->filter($field);
            }
            else
            {
                $setter = 'set' . ucfirst($field);
            }

            if ($metadata->hasAssociation($field))
            {
                $target = $metadata->getAssociationTargetClass($field);

                if ($metadata->isSingleValuedAssociation($field))
                {
                    if (!method_exists($object, $setter))
                    {
                        continue;
                    }

                    $value = $this->toOne($target, $this->hydrateValue($field, $value, $data));

                    if (null === $value
                        && !current($metadata->getReflectionClass()->getMethod($setter)->getParameters())->allowsNull()
                    )
                    {
                        continue;
                    }

                    $object->$setter($value);
                }
                elseif ($metadata->isCollectionValuedAssociation($field))
                {
                    $this->toMany($object, $field, $target, $value);
                }
            }
            else
            {
                if (!method_exists($object, $setter))
                {
                    continue;
                }

                $object->$setter($this->hydrateValue($field, $value, $data));
            }
        }

        return $object;
    }

    /**
     * Extract values from an object using a by-value logic (this means that it uses the entity
     * API, in this case, getters)
     *
     * @param  object $object
     * @throws RuntimeException
     * @return array
     */
    protected function extractByValue($object)
    {
        $fieldNames = array_merge($this->metadata->getFieldNames(), $this->metadata->getAssociationNames());
        $methods    = get_class_methods($object);

        $data = array();
        foreach ($fieldNames as $fieldName) {

            if ($this->getFieldNameFilter() instanceof FilterInterface)
            {
                $filter = new UnderscoreToCamelCase();
                $getter = 'get' . $filter->filter($fieldName);
                $isser  = 'is' . $filter->filter($fieldName);
                $other_isser = 'is' . $filter->filter(preg_replace("/^is/", "", $fieldName));
            }
            else
            {
                $getter = 'set' . ucfirst($fieldName);
                $isser  = 'is' . ucfirst($fieldName);
                $other_isser = 'is' . ucfirst(preg_replace("/^is/", "", $fieldName));
            }

            if (in_array($getter, $methods)) {
                $data[$fieldName] = $this->extractValue($fieldName, $object->$getter(), $object);
            } elseif (in_array($isser, $methods)) {
                $data[$fieldName] = $this->extractValue($fieldName, $object->$isser(), $object);
            } elseif (in_array($other_isser, $methods)) {
                $data[$fieldName] = $this->extractValue($fieldName, $object->$other_isser(), $object);
            }

            // Unknown fields are ignored
        }

        return $data;
    }
} 