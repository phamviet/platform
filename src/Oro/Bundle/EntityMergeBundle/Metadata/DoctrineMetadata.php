<?php

namespace Oro\Bundle\EntityMergeBundle\Metadata;

use Doctrine\ORM\Mapping\ClassMetadataInfo;

class DoctrineMetadata extends Metadata implements MetadataInterface
{
    /**
     * @var string
     */
    protected $sourceClassName;

    /**
     * @param string $sourceClassName
     * @param array $options
     */
    public function __construct($sourceClassName, array $options = [])
    {
        $this->sourceClassName = $sourceClassName;
        parent::__construct($options);
    }

    /**
     * Checks if this field represents simple doctrine field
     *
     * @return bool
     */
    public function isField()
    {
        return !$this->isAssociation();
    }

    /**
     * Checks if this field represents doctrine association
     *
     * @return bool
     */
    public function isAssociation()
    {
        return $this->has('targetEntity') && ($this->has('joinColumns') || $this->has('joinTable'));
    }

    /**
     * Checks if this field represented by collections
     *
     * @return bool
     */
    public function isCollection()
    {
        $sourceCollectionTypes = [
            ClassMetadataInfo::ONE_TO_MANY,
            ClassMetadataInfo::MANY_TO_MANY,
        ];

        $inverseCollectionTypes = [
            ClassMetadataInfo::MANY_TO_ONE,
            ClassMetadataInfo::MANY_TO_MANY,
        ];

        return ($this->isTypeIn($sourceCollectionTypes) && $this->isMappedBySourceEntity()) ||
            ($this->isTypeIn($inverseCollectionTypes) && !$this->isMappedBySourceEntity());
    }

    /**
     * @param array $types
     * @return bool
     */
    protected function isTypeIn(array $types)
    {
        return $this->has('type') && in_array($this->get('type'), $types);
    }

    /**
     * Checks if this metadata relates to field that is mapped in entity
     *
     * @return bool
     */
    public function isMappedBySourceEntity()
    {
        return $this->isField() || $this->sourceClassName == $this->get('sourceEntity');
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        return $this->get('fieldName', true);
    }
}
