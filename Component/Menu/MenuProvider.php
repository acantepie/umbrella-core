<?php

/**
 * Created by PhpStorm.
 * User: acantepie
 * Date: 13/05/17
 * Time: 16:51.
 */

namespace Umbrella\CoreBundle\Component\Menu;

use Umbrella\CoreBundle\Component\Menu\Model\Breadcrumb;
use Umbrella\CoreBundle\Component\Menu\Model\BreadcrumbItem;
use Umbrella\CoreBundle\Component\Menu\Model\Menu;
use Umbrella\CoreBundle\Component\Menu\Model\MenuItem;

/**
 * Class MenuProvider.
 */
class MenuProvider
{
    /**
     * @var MenuFactory
     */
    private $menuFactory;

    /**
     * @var array
     */
    private $menuFactories = [];

    /**
     * @var array
     */
    private $menuRendererFactories = [];

    /**
     * @var array
     */
    private $breadcrumbRendererFactories = [];

    /**
     * @var Menu[]
     */
    private $menus = [];

    /**
     * @var Breadcrumb[][]
     */
    private $breadcrumbs = [];

    /**
     * @var string
     */
    private $defaultAlias;

    /**
     * MenuProvider constructor.
     *
     * @param MenuFactory $menuFactory
     * @param $defaultAlias
     */
    public function __construct(MenuFactory $menuFactory, $defaultAlias = null)
    {
        $this->menuFactory = $menuFactory;
        $this->defaultAlias = $defaultAlias;
    }

    /**
     * @param null $name
     * @return mixed|string
     */
    private function normalizeName($name = null)
    {
        return $name === null ? $this->defaultAlias : $name;
    }

    // ------ Menu provider ------ //

    /**
     * @param $alias
     * @param $factory
     * @param $method
     */
    public function registerMenu($alias, $factory, $method)
    {
        $this->menuFactories[$alias] = [$factory, $method];
    }

    /**
     * @param null $name
     * @return Menu
     */
    public function getMenu($name = null)
    {
        $name = $this->normalizeName($name);

        if (!isset($this->menuFactories[$name])) {
            throw new \InvalidArgumentException(sprintf('The menu "%s" is not defined.', $name));
        }

        if (!array_key_exists($name, $this->menus)) {
            list($factory, $method) = $this->menuFactories[$name];
            $this->menus[$name] = $factory->$method($this->menuFactory);
        }

        return $this->menus[$name];
    }

    // ------ Menu renderer provider ------ //

    /**
     * @param $alias
     * @param $factory
     * @param $method
     */
    public function registerMenuRenderer($alias, $factory, $method)
    {
        $this->menuRendererFactories[$alias] = [$factory, $method];
    }

    /**
     * @param Menu $menu
     * @param null $name
     * @return string
     */
    public function renderMenu(Menu $menu, $name = null)
    {
        $name = $this->normalizeName($name);

        if (!isset($this->menuRendererFactories[$name])) {
            throw new \InvalidArgumentException(sprintf('The menu renderer "%s" is not defined.', $name));
        }

        list($factory, $method) = $this->menuRendererFactories[$name];

        return $factory->$method($menu);
    }

    // ------ Breadcrumb provider ------ //

    /**
     * @param MenuItem $menuItem
     * @param null $name
     * @return Breadcrumb
     */
    public function getBreadcrumb(MenuItem $menuItem, $name = null)
    {
        $name = $this->normalizeName($name);

        $iPath = $menuItem->getPath();

        if (!isset($this->breadcrumbs[$name][$iPath])) {
            $bis = [];

            $currentMenuItem = $menuItem;
            while(!$currentMenuItem->isRoot()) {
                $bis[] = BreadcrumbItem::createFromMenuItem($currentMenuItem);
                $currentMenuItem = $currentMenuItem->getParent();
            }

            $this->breadcrumbs[$name][$iPath] = new Breadcrumb(array_reverse($bis));
        }

        return $this->breadcrumbs[$name][$iPath];
    }

    // ------ Breadcrumb renderer provider ------ //

    /**
     * @param $alias
     * @param $factory
     * @param $method
     */
    public function registerBreadcrumbRenderer($alias, $factory, $method)
    {
        $this->breadcrumbRendererFactories[$alias] = [$factory, $method];
    }

    /**
     * @param null $name
     * @return mixed
     */
    public function renderBreadcrumb(Breadcrumb $breadcrumb, $name = null)
    {
        $name = $this->normalizeName($name);

        if (!isset($this->breadcrumbRendererFactories[$name])) {
            throw new \InvalidArgumentException(sprintf('The breadcrumb renderer "%s" is not defined.', $name));
        }

        list($factory, $method) = $this->breadcrumbRendererFactories[$name];

        return $factory->$method($breadcrumb);
    }
}
