<?php

namespace Visualnet\VisualRecruiter\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * Group form
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UserBundle\Form
 * @access public
 * @copyright visualnet.pl
 */
class Group extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add("name", "text", array("label" => "Nazwa firmy"));
        $builder->add("street", "text", array("label" => "Ulica"));
        $builder->add("flat", "text", array("label" => "Numer"));
        $builder->add("city", "text", array("label" => "Miasto"));
        $builder->add("postcode", "text", array("label" => "Kod pocztowy", "attr" => array("class" => "postcode")));
        $builder->add("nip", "text", array("label" => "NIP", "attr" => array("class" => "nip")));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            "data_class" => "Visualnet\UserBundle\Model\Group",
        );
    }

    public function getName()
    {
        return "group";
    }

}
