<?php

namespace Visualnet\VisualRecruiter\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * UserRegister form
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UserBundle\Form
 * @access public
 * @copyright visualnet.pl
 */
class UserRegister extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add("type", "choice", array(
            "required" => true,
            "choices" => array(
                "individual" => "Osoba fizyczna",
                "firm" => "Firma"),
            "label" => "Typ użytkownika",
            "empty_value" => "Wybierz opcję",
        ));

        $builder->add("name", "text", array("label" => "Imię"));
        $builder->add("surname", "text", array("label" => "Nazwisko"));
        $builder->add("username", "text", array("label" => "Login"));
        $builder->add("password", "password", array("label" => "Hasło"));
        $builder->add("email", "text", array("label" => "Email"));

        $builder->add("street", "text", array("label" => "Ulica"));
        $builder->add("flat", "text", array("label" => "Numer"));
        $builder->add("city", "text", array("label" => "Miasto"));
        $builder->add("postcode", "text", array("label" => "Kod pocztowy", "attr" => array("class" => "postcode")));

        $builder->add("is_agree_processing", "checkbox", array(
            "label" => "Wyrażam zgodę na przetwarzanie danych osobowych (zgodnie z Ustawą z dn.29.08.1997 o ochronie danych osobowych, Dz.U. nr 133 poz 883 z późn zm)"
                )
        );

        $builder->add("is_agree_regulations", "checkbox", array(
            "label" => "Akceptuję warunki regulaminu"
                )
        );

        $builder->add('captcha', 'captcha', array(
            "label" => "Proszę przepisać kod",
            "quality" => 90,
            "keep_value" => false,
            "height" => 50,
            "width" => 150
                )
        );

        $builder->add('group', new Group());
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
