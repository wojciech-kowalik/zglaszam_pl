<?php

namespace Visualnet\MenuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Menu form
 * 
 * @author w.kowalik 
 * @package Visualnet\MenuBundle\Form
 * @access public
 * @copyright visualnet.pl
 */
class Menu extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add("is_active", "checkbox", array("label" => "Aktywny"));
        $builder->add("url", "text");

        $builder->add('menuI18ns', 'collection', array(
            'type' => new MenuI18n(),
            'by_reference' => true,
        ));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            "data_class" => "Visualnet\MenuBundle\Model\Menu",
        );
    }

    public function getName()
    {
        return "menu";
    }

}
