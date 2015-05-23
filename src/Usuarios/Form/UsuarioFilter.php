<?php

namespace Usuarios\Form;

use Zend\InputFilter\InputFilter;

class UsuarioFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'nome',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array('name' => 'NotEmpty'),
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'max' => 100
                    )
                )
            ),
        ));

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
            'name' => 'senha',
            'required' => false,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'max' => 8,
                        'min' => 4
                    )
                )
            ),
        ));

        $this->add(array(
            'name' => 'repassword',
            'required' => false,
            'validators' => array(
                array(
                    'name' => 'Identical',
                    'options' => array(
                        'token' => 'senha'
                    )
                )
            )
        ));
    }
}
