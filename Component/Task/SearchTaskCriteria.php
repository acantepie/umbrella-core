<?php
/**
 * Created by PhpStorm.
 * User: acantepie
 * Date: 20/01/19
 * Time: 14:52
 */

namespace Umbrella\CoreBundle\Component\Task;

/**
 * Class SearchTaskCriteria
 */
class SearchTaskCriteria
{
    /**
     * @var array
     */
    public $states = [];

    /**
     * @var string
     */
    public $tag;

    /**
     * @var string
     */
    public $handlerAlias;

    /**
     * @var null|int
     */
    public $maxResults = null;
}
