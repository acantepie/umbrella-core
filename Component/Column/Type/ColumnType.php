<?php
/**
 * Created by PhpStorm.
 * User: acantepie
 * Date: 16/04/18
 * Time: 11:21
 */

namespace Umbrella\CoreBundle\Component\Column\Type;

use Umbrella\CoreBundle\Component\Column\Column;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ColumnType
 */
class ColumnType
{
    /**
     * @param OptionsResolver $resolver
     * @see Column to get options list
     */
    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
