<?php

namespace Visualnet\VisualRecruiter\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * Role form
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UserBundle\Form
 * @access public
 * @copyright visualnet.pl
 */
class Role extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {

        $builder->add("name", "text", array("label" => "Nazwa"));
        $builder->add("description", "textarea", array("label" => "Opis"));

        $builder->add("type", "choice", array(
            "label" => "Typ roli",
            "choices" => array("system" => "systemowa", "user" => "użytkownika")
        ));

        $builder->add("is_active", "checkbox", array("label" => "Aktywność"));
    }

    public function getDefaultOptions(array $options)
    {

        return array(
            "data_class" => "Visualnet\UserBundle\Model\Role",
        );
    }

    public function getName()
    {
        return "role";
    }

}
