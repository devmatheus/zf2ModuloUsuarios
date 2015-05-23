<?php

namespace Usuarios\Controller;

use Base\Controller\CrudController;

class IndexController extends CrudController
{
    public function __construct()
    {
        parent::init(__NAMESPACE__);
        $this->tituloModulo     = 'Usuários';
        $this->form             = 'Usuarios\Form\Usuario';
        $this->entity           = 'Usuarios\Entity\Usuario';
        $this->service          = 'Usuarios\Service\Usuario';
        $this->grid['campos'] = array(
            'id'         => array('label' => 'ID'),
            'nome'       => array('label' => 'Nome'),
            'status'     => array(
                'label'     => 'Status',
                'formatter' => 'Usuarios\Formatter\Status'
            ),
            'email'      => array('label' => 'E-mail'),
            'grupo' => array('label' => 'Grupo')
        );
        $this->grid['relacoes'] = array(
            'grupo' => array(
                'entity'     => 'Acl\Entity\Grupo',
                'campo'      => 'nome',
                'referencia' => 'id'
            )
        );
        $this->varsView['restDisabled'] = true;
    }
}
