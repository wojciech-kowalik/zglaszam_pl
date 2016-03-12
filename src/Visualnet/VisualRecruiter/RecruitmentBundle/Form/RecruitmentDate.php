<?php

namespace Visualnet\VisualRecruiter\RecruitmentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Visualnet\VisualRecruiter\FormBundle\Model;

/**
 * Recruitment date form
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\RecruitmentBundle\Form
 * @access public
 * @copyright visualnet.pl
 */
class RecruitmentDate extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {
                
        $builder->add("event_date_from", "date", array(    
            "widget" => "single_text",
            "format" => "yyyy-MM-dd", 
            "label" => "Data zdarzenia od")
                );
        
        $builder->add("event_date_to", "date", array(
            "widget" => "single_text",
            "format" => "yyyy-MM-dd",                 
            "label" => "Data zdarzenia do")
                );
                
        $builder->add("no_active_text", "textarea", array("label" => "Tekst wyświetlany gdy termin nieaktywny"));
        $builder->add("is_active", "checkbox", array("label" => "Aktywny"));
        $builder->add("is_not_set_event_date", "checkbox", array("label" => "Termin nieokreślony"));
        
        $builder->add("set_limit", "text", array("label" => "Ilość miejsc"));        
        $builder->add("used_limit", "text", array("label" => "Ilość zarejestrowanych"));
        $builder->add("is_visible_limit", "checkbox", array("label" => "Limit widoczny na formularzu rejestracji"));
        $builder->add("is_automatic_qualify", "checkbox", array("label" => "Automatyczna kwalifikacja"));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            "data_class" => "Visualnet\VisualRecruiter\RecruitmentBundle\Model\RecruitmentDate",
        );
    }

    public function getName()
    {
        return "recruitment_date";
    }

}
