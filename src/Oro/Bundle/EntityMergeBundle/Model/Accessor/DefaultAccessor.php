<?php

namespace Oro\Bundle\EntityMergeBundle\Model\Accessor;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

use Oro\Bundle\EntityMergeBundle\Metadata\FieldMetadata;

class DefaultAccessor implements AccessorInterface
{
    /**
     * @var PropertyAccessor
     */
    protected $propertyAccessor;

    /**
     * @return PropertyAccessor
     */
    public function getName()
    {
        return 'default';
    }

    /**
     * Checks if this class supports accessing entity
     *
     * @param string        $entity
     * @param FieldMetadata $metadata
     * @return string
     */
    public function supports($entity, FieldMetadata $metadata)
    {
        return !$metadata->hasDoctrineMetadata() || $metadata->getDoctrineMetadata()->isMappedBySourceEntity();
    }

    /**
     * {@inheritdoc}
     */
    public function getValue($entity, FieldMetadata $metadata)
    {
        if ($metadata->has('getter')) {
            $getter = $metadata->get('getter');
            return $entity->$getter();
        }

        return $this
            ->getPropertyAccessor()
            ->getValue($entity, $metadata->getFieldName());
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($entity, FieldMetadata $metadata, $value)
    {
        if ($metadata->has('setter')) {
            $setter = $metadata->get('setter');
            $entity->$setter($value);

            return;
        }

        $this->getPropertyAccessor()
            ->setValue(
                $entity,
                $metadata->getFieldName(),
                $value
            );
    }

    /**
     * @return PropertyAccessor
     */
    protected function getPropertyAccessor()
    {
        if (!$this->propertyAccessor) {
            $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        }
        return $this->propertyAccessor;
    }
}
