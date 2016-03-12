<?php

namespace Visualnet\VisualRecruiter\FormBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Visualnet\VisualRecruiter\FormBundle\Model;

/**
 * Form FormQuestion
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\FormBundle\Form
 * @access public
 * @copyright visualnet.pl
 */
class FormQuestion extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {

        $builder->add("label", "textarea", array("label" => "Opis pola"));
        $builder->add("export_name", "text", array("label" => "Nazwa pola do exportu"));
        $builder->add("is_required", "checkbox", array("label" => "Wymagane"));
        $builder->add("is_export", "checkbox", array("label" => "Export"));
       
    }

    public function getDefaultOptions(array $options)
    {

        return array(
            "data_class" => "Visualnet\VisualRecruiter\FormBundle\Model\FormQuestion",
        );
    }

    public function getName()
    {
        return "formquestion";
    }

}
