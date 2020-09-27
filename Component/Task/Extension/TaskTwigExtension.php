<?php
/**
 * Created by PhpStorm.
 * User: acantepie
 * Date: 19/01/19
 * Time: 21:54
 */

namespace Umbrella\CoreBundle\Component\Task\Extension;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;

/**
 * Class TaskTwigExtension
 */
class TaskTwigExtension extends AbstractExtension
{
    /**
     * @var TaskHelper
     */
    private $taskHelper;

    /**
     * TaskTwigExtension constructor.
     * @param TaskHelper $taskHelper
     */
    public function __construct(TaskHelper $taskHelper)
    {
        $this->taskHelper = $taskHelper;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('render_task_state', [$this->taskHelper, 'renderState'], ['is_safe' => ['html']]),
            new TwigFilter('render_task_runtime', [$this->taskHelper, 'renderRuntime'], ['is_safe' => ['html']]),
            new TwigFilter('render_task_progress', [$this->taskHelper, 'renderProgress'], ['is_safe' => ['html']]),
        ];
    }
}