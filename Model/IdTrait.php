<?php

namespace Umbrella\CoreBundle\Model;

/**
 * Trait IdTrait
 */
trait IdTrait
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;
}
