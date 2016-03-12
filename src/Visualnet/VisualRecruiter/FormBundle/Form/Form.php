<?php

namespace Visualnet\VisualRecruiter\FormBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Visualnet\VisualRecruiter\FormBundle\Model;

/**
 * Form form
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\FormBundle\Form
 * @access public
 * @copyright visualnet.pl
 */
class Form extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {

        $builder->add("name", "text", array("label" => "Nazwa"));
        $builder->add("is_active", "checkbox", array("label" => "Aktywny"));
       
    }

    public function getDefaultOptions(array $options)
    {

        return array(
            "data_class" => "Visualnet\VisualRecruiter\FormBundle\Model\Form",
        );
    }

    public function getName()
    {
        return "formtype";
    }

}
