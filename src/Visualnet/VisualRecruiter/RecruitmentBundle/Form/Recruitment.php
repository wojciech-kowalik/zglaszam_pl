<?php

namespace Visualnet\VisualRecruiter\RecruitmentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Visualnet\VisualRecruiter\FormBundle\Model;

/**
 * Recruitment form
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\RecruitmentBundle\Form
 * @access public
 * @copyright visualnet.pl
 */
class Recruitment extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {
        
        $builder->add("name", "text", array("label" => "Nazwa"));
        $builder->add("alias_name", "text", array("label" => "Alias dla domeny"));
        $builder->add("place", "textarea", array("label" => "Miejsce"));
        $builder->add("description", "textarea", array("label" => "Opis"));
        $builder->add("is_active", "checkbox", array("label" => "Aktywny"));
       
    }

    public function getDefaultOptions(array $options)
    {

        return array(
            "data_class" => "Visualnet\VisualRecruiter\RecruitmentBundle\Model\Recruitment",
        );
    }

    public function getName()
    {
        return "recruitment";
    }

}
