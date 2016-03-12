<?php

namespace Visualnet\VisualRecruiter\QuestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Visualnet\VisualRecruiter\QuestionBundle\Model;
use Visualnet\VisualRecruiter\QuestionBundle\Helper;
/**
 * Form question
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\QuestionBundle\Form
 * @access public
 * @copyright visualnet.pl
 */
class Question extends AbstractType
{

    private $validators;
    
    public function __construct($validators){
        $this->validators = $validators;
    
    }
  
    public function buildForm(FormBuilder $builder, array $options)
    {

        $builder->add("name", "text", array("label" => "Nazwa"));
        $builder->add("label", "textarea", array("label" => "Opis pola"));
        $builder->add("answers", "textarea", array("label" => "Możliwe odpowiedzi"));
        
        $builder->add("limit", "text", array("label" => "Maksymalna długość"));
        
        $types = Model\QuestionPeer::getValueSet(Model\QuestionPeer::TYPE);
        $predefinedValidators = $this->validators;
        
        $builder->add("type", "choice", array(
            "label" => "Typ",
            "choices" => array_combine($types, $types)
        ));
        
        
        $builder->add("validation_rule_optional", "textarea", array("label" => "Reguła walidacji"));
        
        $builder->add("validation_rule_predefined", "choice", array(
            "empty_value" => "wybierz:",
            "label" => "Dostępne walidacje",
            "choices" => $predefinedValidators
        ));        

    }

    public function getDefaultOptions(array $options)
    {
        return array(
            "data_class" => "Visualnet\VisualRecruiter\QuestionBundle\Model\Question",
        );
    }

    public function getName()
    {
        return "question";
    }

}
