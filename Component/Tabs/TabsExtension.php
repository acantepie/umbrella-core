<?php


namespace Umbrella\CoreBundle\Component\Tabs;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class TabsExtension
 */
class TabsExtension extends AbstractExtension
{
    /**
     * @var TabsHelper
     */
    private $tabsHelper;

    /**
     * TabsExtension constructor.
     * @param TabsHelper $tabsHelper
     */
    public function __construct(TabsHelper $tabsHelper)
    {
        $this->tabsHelper = $tabsHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('nav_config', [$this->tabsHelper, 'navConfig']),
            new TwigFunction('nav_start', [$this->tabsHelper, 'navStart'], ['is_safe' => ['html']]),
            new TwigFunction('nav_end', [$this->tabsHelper, 'navEnd'], ['is_safe' => ['html']]),
            new TwigFunction('nav_item', [$this->tabsHelper, 'navItem'], ['is_safe' => ['html']])
        ];
    }
}