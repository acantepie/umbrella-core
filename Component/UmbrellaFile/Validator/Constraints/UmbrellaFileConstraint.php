<?php

namespace Umbrella\CoreBundle\Component\UmbrellaFile\Validator\Constraints;

use Symfony\Component\Validator\Constraints\File;
use Umbrella\CoreBundle\Component\UmbrellaFile\Validator\UmbrellaFileValidator;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @property int $maxSize
 */
class UmbrellaFileConstraint extends File
{
    /**
     * @return string
     */
    public function validatedBy()
    {
        return UmbrellaFileValidator::class;
    }
}
