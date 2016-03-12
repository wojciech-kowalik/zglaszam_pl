<?php

namespace Visualnet\VisualRecruiter\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * UserRole form
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\UserBundle\Form
 * @access public
 * @copyright visualnet.pl
 */
class UserRole extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {

        $builder->add("user_id");
        $builder->add("role_id");
    }

    public function getDefaultOptions(array $options)
    {

        return array(
            "data_class" => "Visualnet\UserBundle\Model\UserRole",
        );
    }

    public function getName()
    {
        return "userrole";
    }

}
