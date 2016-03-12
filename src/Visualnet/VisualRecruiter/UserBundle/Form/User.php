<?php

namespace Visualnet\VisualRecruiter\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * User form
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UserBundle\Form
 * @access public
 * @copyright visualnet.pl
 */
class User extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {

        $builder->add("is_active", "checkbox", array("label" => "Aktywny"));
        $builder->add("name", "text", array("label" => "Imię"));
        $builder->add("surname", "text", array("label" => "Nazwisko"));
        $builder->add("username", "text", array("label" => "Login"));
        $builder->add("email", "text", array("label" => "Email"));

        $builder->add("street", "text", array("label" => "Ulica"));
        $builder->add("flat", "text", array("label" => "Numer"));
        $builder->add("city", "text", array("label" => "Miasto"));
        $builder->add("postcode", "text", array("label" => "Kod pocztowy", "attr" => array("class" => "postcode")));
    }

    public function getDefaultOptions(array $options)
    {

        return array(
            "data_class" => "Visualnet\UserBundle\Model\User",
        );
    }

    public function getName()
    {
        return "user";
    }

}
