<?php

namespace Usuarios\Form;

use Zend\Form\Form;
use Zend\Form\Element as Element;

class Usuario extends Form
{
    public function __construct($grupoPairs)
    {
        parent::__construct('usuario');

        $this->setAttribute('method', 'post');
        $this->setInputFilter(new UsuarioFilter());

        $id = new Element\Hidden('id');
        $this->add($id);

        $nome = new Element\Text('nome');
        $nome->setLabel('Nome')
            ->setAttributes(array(
                'id' => 'nome',
                'required' => 'required',
                'placeholder' => 'Entre com o nome',
                'maxlength' => 100
            ));
        $this->add($nome);

        $email = new Element\Email('email');
        $email->setLabel('Email')
            ->setAttributes(array(
                'id' => 'email',
                'class' => 'form-control',
                'placeholder' => 'Entre com o email',
                'required' => 'required',
                'maxlength' => 100
            ));
        $this->add($email);
        
        $grupo = new Element\Select();
        $grupo->setLabel("Grupo")
                ->setName("grupo")
                ->setOptions(array('value_options' => $grupoPairs));
        $this->add($grupo);
        
        $status = new Element\Radio('status');
        $status->setLabel('Status')
                ->setValue(1)
                ->setValueOptions(array(
                    array(
                        'value' => '1',
                        'label' => 'Ativo',
                        'label_attributes' => array(
                            'class' => 'btn btn-primary'
                        )
                    ),
                    array(
                        'value' => '0',
                        'label' => 'Inativo',
                        'label_attributes' => array(
                            'class' => 'btn btn-primary'
                        )
                    )
                ))->setOptions(array(
                    'label_attributes' => array(
                        'class'  => 'col-sm-2 control-label'
                    )
                ));
        $this->add($status);

        $senha = new Element\Password('senha');
        $senha->setLabel('Senha')
            ->setAttributes(array(
                'id' => 'senha',
                'maxlength' => 8
            ));
        $this->add($senha);

        $repassword = new Element\Password('repassword');
        $repassword->setLabel('Repita a senha')
            ->setAttributes(array(
                'maxlength' => 8
            ));
        $this->add($repassword);

        $submit = new Element\Submit('submit');
        $submit->setAttributes(array(
            'class' => 'btn btn-success'
        ))->setValue('Salvar');
        $this->add($submit);
    }
}
