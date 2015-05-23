<?php

namespace Usuarios\Form;

use Zend\Form\Form;

class Login extends Form
{
    public function __construct()
    {
        parent::__construct('login');
        $this->setInputFilter(new LoginFilter());

        $this->setAttribute('method', 'post');

        $email = new \Zend\Form\Element\Email('email');
        $email->setLabel('Email')
                ->setAttributes(array(
                    'id' => 'email',
                    'autofocus' => 'autofocus',
                    'class' => 'form-control',
                    'placeholder' => 'Email',
                    'required' => 'required',
                    'maxlength' => 100,
                    'autofocus' => 'autofocus'
                ));
        $this->add($email);

        $password = new \Zend\Form\Element\Password('password');
        $password->setLabel('Senha')
                ->setAttributes(array(
                    'id' => 'password',
                    'class' => 'form-control',
                    'placeholder' => 'Senha',
                    'required' => 'required',
                    'maxlength' => 8
                ));
        $this->add($password);

        $csrf = new \Zend\Form\Element\Csrf('security_auth');
        $csrfValidation = new \Zend\Validator\Csrf();
        $csrfValidation->setMessage('O envio do formulário não foi feito pelo Painel Administrativo.');
        $csrf->setCsrfValidator($csrfValidation);
        $this->add($csrf);

        $submit = new \Zend\Form\Element\Submit('submit');
        $submit->setAttribute('class', 'btn btn-primary btn-block')
                ->setValue('Logar');
        $this->add($submit);
    }
}
