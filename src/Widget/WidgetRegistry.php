<?php

namespace Umbrella\CoreBundle\Widget;

use Umbrella\CoreBundle\Widget\Type\WidgetType;

class WidgetRegistry
{
    public const TAG_TYPE = 'umbrella.widget.type';

    /**
     * @var WidgetType[]
     */
    protected array $types = [];

    public function registerType(string $name, WidgetType $type)
    {
        $this->types[$name] = $type;
    }

    public function getType(string $name): WidgetType
    {
        if (!isset($this->types[$name])) {
            throw new \InvalidArgumentException(sprintf('Widget "%s" doesn\'t exist, maybe you have forget to register it ?', $name));
        }

        return $this->types[$name];
    }
}
