<?php

namespace Visualnet\VisualRecruiter\FormBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Visualnet\VisualRecruiter\FormBundle\Model;
use Visualnet\VisualRecruiter\RecruitmentBundle\Helper as RecruitmentHelper;
use Visualnet\VisualRecruiter\QuestionBundle\Helper as QuestionHelper;
use Visualnet\VisualRecruiter\UtilsBundle\Helper;

/**
 * Form service
 * 
 * @author w.kowalik 
 * @package Visualnet\VisualRecruiter\FormBundle\Service
 * @access public
 * @copyright visualnet.pl
 */
class Form
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Set data what will were used in form
     * 
     * @param ArrayIterator $questions Reference to questions
     * @param array $defaults Reference to defaults fields
     * @return array 
     */
    public function setData(\ArrayIterator &$questions, array &$defaults)
    {

        // check if iterator isn't empty
        if($questions->count() == 0){
            throw new \Exception('No iterator data');
        }
        
        // iterate on collections
        while ($questions->valid()) {

            $answers = $questions->current()->getQuestion()->getAnswers();

            if (!empty($answers)) {
                $questions->current()->getQuestion()->answersArray = explode(';', $answers);
            }

            // make data array
            $toSerialize = array(
                'validate' => ($questions->current()->getQuestion()->getValidationRulePredefined()) ? $questions->current()->getQuestion()->getValidationRulePredefined() : $questions->current()->getQuestion()->getValidationRuleOptional(),
                'type' => $questions->current()->getQuestion()->getType(),
                'optional_validate_rule' => null,
                'limit' => $questions->current()->getQuestion()->getLimit(),
                'required' => $questions->current()->getIsRequired()
            );

            // if validation rule is null
            if (is_null($toSerialize['validate'])) {
                $toSerialize['validate'] = false;
            }

            $questions->current()->getQuestion()->mask = null;
            $questions->current()->getQuestion()->validate_name = null;
            $questions->current()->getQuestion()->optional_validate_rule = null;

            // check if validate class exists 
            if (class_exists($toSerialize['validate'])) {

                $validate = Helper\String::getClassName($toSerialize['validate'], true);

                $expression = $validate . '_expression';
                $param = $this->container->getParameter('validator');

                if (isset($param[$expression])) {
                    $questions->current()->getQuestion()->mask = $param[$expression];
                }

                $questions->current()->getQuestion()->validate = $validate;
                
            } else { // if validate class not exists check if optional rule exists - regex
                
                if (!is_null($toSerialize['validate'])) {

                    $questions->current()->getQuestion()->validate = Helper\String::getClassName(QuestionHelper\Question::REGEX_VALIDATION_CLASS, true);
                    $toSerialize['optional_validate_rule'] = $toSerialize['validate'];

                    // get regex validation class
                    $toSerialize['validate'] = QuestionHelper\Question::REGEX_VALIDATION_CLASS;
                }
            }

            // make validate data
            $questions->current()->getQuestion()->data = base64_encode(serialize($toSerialize));
            $questions->next();
        }

        // delete previous array data
        unset($toSerialize);
        
        // iterate over default fields
        if (isset($defaults) and !empty($defaults)) {

            foreach ($defaults as $key => $value) {

                $toSerialize = array(
                    'validate' => (isset($this->predefinedValidators[$value['validate']])) ? $this->predefinedValidators[$value['validate']] : '',
                    'type' => $value['type'],
                    'optional_validate_rule' => null,
                    'required' => $value['required']
                );

                $defaults[$key]['data'] = base64_encode(serialize($toSerialize));
            }
        }     
        
    }

}
