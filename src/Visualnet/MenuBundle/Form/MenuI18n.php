<?php

namespace Visualnet\MenuBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * MenuI18n form
 * 
 * @author w.kowalik 
 * @package Visualnet\MenuBundle\Form
 * @access public
 * @copyright visualnet.pl
 */
class MenuI18n extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add("locale", "hidden", array("label" => "Językowość"));
        $builder->add("name", "text", array("label" => "Nazwa elementu"));
        $builder->add("content", "ckeditor", array("label" => "Zawartość"));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            "data_class" => "Visualnet\MenuBundle\Model\MenuI18n",
        );
    }

    public function getName()
    {
        return "translate";
    }

}
