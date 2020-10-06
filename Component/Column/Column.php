<?php
/**
 * Created by PhpStorm.
 * User: acantepie
 * Date: 13/05/17
 * Time: 12:46.
 */

namespace Umbrella\CoreBundle\Component\Column;

use Symfony\Component\OptionsResolver\Options;
use Umbrella\CoreBundle\Component\ComponentView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Umbrella\CoreBundle\Component\Column\Type\ColumnType;

/**
 * Class Column.
 */
class Column
{
    /**
     * @var ColumnType
     */
    private $type;

    /**
     * @var array
     */
    private $options;

    /**
     * @param $data
     * @return string
     */
    public function render($data)
    {
        if (is_callable($this->options['renderer'])) {
            return call_user_func($this->options['renderer'], $data, $this->options);
        } else {
            return (string)$data;
        }
    }

    /**
     * @param ColumnType $type
     */
    public function setType(ColumnType $type)
    {
        $this->type = $type;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired('id')
            ->setAllowedTypes('id', 'string')

            ->setDefault('label', function (Options $options) {
                return $options['id'];
            })
            ->setAllowedTypes('label', ['null', 'string'])

            ->setDefault('label_prefix', 'table.')
            ->setAllowedTypes('label_prefix', ['null', 'string'])

            ->setDefault('translation_domain', 'messages')
            ->setAllowedTypes('translation_domain', ['null', 'string'])

            ->setDefault('default_order', null)
            ->setAllowedValues('default_order', [null, 'ASC', 'DESC'])

            ->setDefault('orderable', true)
            ->setAllowedTypes('orderable', ['bool'])

            ->setDefault('order_by', null)
            ->setAllowedTypes('order_by', ['null', 'string', 'array'])

            ->setDefault('class', null)
            ->setAllowedTypes('class', ['null', 'string'])

            ->setDefault('width', null)
            ->setAllowedTypes('width', ['null', 'string'])

            ->setDefault('renderer', null)
            ->setAllowedTypes('renderer', ['null', 'callable']);
    }

    /**
     * @return array
     */
    public function getJsOptions()
    {
        return [
            'orderable' => $this->options['orderable'] && $this->options['order_by'] !== null,
            'className' => $this->options['class']
        ];
    }

    /**
     * @return string
     */
    public function getDefaultOrder()
    {
        return $this->options['default_order'];
    }

    /**
     * @return array
     */
    public function getOrderBy()
    {
        return (array) $this->options['order_by'];
    }

    /**
     * @return ComponentView
     */
    public function createView() : ComponentView
    {
        $componentView = new ComponentView();
        $componentView->template = '@UmbrellaCore/DataTable/column_header.html.twig';

        $componentView->vars['attr'] = [
            'class' => $this->options['class'],
            'style' => $this->options['width'] ?  sprintf('width:%s', $this->options['width']) : null,
        ];

        $componentView->vars['label'] = $this->options['label'];
        $componentView->vars['label_prefix'] = $this->options['label_prefix'];
        $componentView->vars['translation_domain'] = $this->options['translation_domain'];

        return $componentView;
    }
}
