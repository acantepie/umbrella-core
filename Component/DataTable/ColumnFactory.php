<?php

/**
 * Created by PhpStorm.
 * User: acantepie
 * Date: 23/05/17
 * Time: 20:03.
 */

namespace Umbrella\CoreBundle\Component\DataTable;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Umbrella\CoreBundle\Component\DataTable\Model\Column;
use Umbrella\CoreBundle\Component\DataTable\Type\ColumnType;

/**
 * Class ColumnFactory.
 */
class ColumnFactory
{
    /**
     * @var ColumnType[]
     */
    private $columnTypes = array();

    /**
     * @param $id
     * @param ColumnType $columnType
     */
    public function registerColumnType($id, ColumnType $columnType)
    {
        $this->columnTypes[$id] = $columnType;
    }

    /**
     * @param $typeClass
     * @param array $options
     *
     * @return Column
     */
    public function create($typeClass, array $options = array())
    {
        $type = $this->createType($typeClass);
        $column = new Column();

        $resolver = new OptionsResolver();
        $column->configureOptions($resolver);
        $type->configureOptions($resolver);
        $resolvedOptions = $resolver->resolve($options);
        $column->setOptions($resolvedOptions);

        return $column;
    }


    /**
     * @param $typeClass
     * @return ColumnType
     */
    private function createType($typeClass)
    {
        if ($typeClass !== ColumnType::class && !is_subclass_of($typeClass, ColumnType::class)) {
            throw new \InvalidArgumentException("Class '$typeClass' must extends ColumnType class.");
        }

        if (array_key_exists($typeClass, $this->columnTypes)) {
            return $this->columnTypes[$typeClass];
        } else {
            return new $typeClass();
        }
    }
}
