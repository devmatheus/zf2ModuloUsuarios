<?php

namespace Usuarios\Service;

use Doctrine\ORM\EntityManager;
use Base\Service\AbstractService;

class Usuario extends AbstractService
{
    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->entity = 'Usuarios\Entity\Usuario';
    }
    
    public function insert(array $data)
    {
        $data['grupo'] = $this->em->getReference('Acl\Entity\Grupo', $data['grupo']);
        return parent::insert($data);
    }

    public function update(array $data)
    {
        if (empty($data['senha'])) {
            unset($data['senha']);
        }
        $data['grupo'] = $this->em->getReference('Acl\Entity\Grupo', $data['grupo']);
        return parent::update($data);
    }
    
    public function delete($id)
    {
        return false;
    }
}
