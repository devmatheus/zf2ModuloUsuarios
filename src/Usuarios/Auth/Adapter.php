<?php

namespace Usuarios\Auth;

use Zend\Authentication\Adapter\AdapterInterface,
    Zend\Authentication\Result;
use Doctrine\ORM\EntityManager;

class Adapter implements AdapterInterface
{
    /**
     * @var EntityManager
     */
    protected $em;
    protected $email;
    protected $password;
    protected $config;

    public function __construct(EntityManager $em, $config)
    {
        $this->em     = $em;
        $this->config = $config;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function authenticate()
    {
        $repository = $this->em->getRepository($this->config['entities']['Usuarios\Entity\Usuario']);
        $user = $repository->findByEmailAndPassword($this->getEmail(), $this->getPassword());

        if ($user) {
            return new Result(Result::SUCCESS, array('user' => array(
                'id'         => $user->getId(),
                'nome'       => $user->getNome(),
                'email'      => $user->getEmail(),
                'grupo'      => $user->getGrupo()->getId(),
                'grupo_nome' => $user->getGrupo()->getNome(),
                'status'     => $user->getStatus()
            )), array('OK'));
        }
        return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, array());
    }
}
