<?php

namespace Usuarios\Form;

use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'email',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array('name' => 'NotEmpty'),
                array('name' => 'EmailAddress'),
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'max' => 100
                    )
                )
            )
        ));

        $this->add(array(
            'name' => 'password',
            'required' => true,
            'validators' => array(
                array('name' => 'NotEmpty'),
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'max' => 8,
                        'min' => 4
                    )
                )
            ),
        ));
    }
}
