<?php

namespace Usuarios\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Math\Rand,
    Zend\Crypt\Key\Derivation\Pbkdf2;
use Zend\Stdlib\Hydrator;

/**
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="Usuarios\Repository\UsuarioRepository")
 */
class Usuario
{
    const STATUS_ATIVO   = 1;
    const STATUS_INATIVO = 0;
    
    public static $translate = [
        'status' => [
            self::STATUS_INATIVO => 'Inativo',
            self::STATUS_ATIVO => 'Ativo'
        ]
    ];

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer", nullable=false, length=11)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="nome", type="string", length=45, nullable=false)
     * @var string
     */
    protected $nome;

    /**
     * @ORM\Column(name="email", type="string", length=45, nullable=false)
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(name="senha", type="string", length=255, nullable=false)
     * @var string
     */
    protected $senha;

    /**
     * @ORM\Column(name="salt", type="string", length=255, nullable=false)
     * @var string
     */
    protected $salt;
    
    /**
     * @ORM\ManyToOne(targetEntity="Acl\Entity\Grupo", inversedBy="usuarios")
     * @ORM\JoinColumn(name="acl_grupo_id", referencedColumnName="id", nullable=false)
     */
    protected $grupo;
    
    /**
     * @ORM\Column(name="status", type="integer", length=1, nullable=false)
     * @var integer
     */
    protected $status;

    /**
     * @ORM\OneToMany(targetEntity="Log\Entity\Log", mappedBy="usuario")
     */
    protected $logs;

    public function __construct($options = null)
    {
        $this->salt = base64_encode(Rand::getBytes(8, true));
        
        $hydrator = new Hydrator\ClassMethods;
        $hydrator->hydrate($options, $this);
        
        $this->logs = new ArrayCollection();
    }

    function getId()
    {
        return $this->id;
    }

    function getNome()
    {
        return $this->nome;
    }

    function getEmail()
    {
        return $this->email;
    }

    function getSenha()
    {
        return $this->senha;
    }

    function getSalt()
    {
        return $this->salt;
    }

    function getGrupo()
    {
        return $this->grupo;
    }

    function getStatus()
    {
        return $this->status;
    }

    function getLogs()
    {
        return $this->logs;
    }
    
    function setId($id)
    {
        $this->id = $id;
    }

    function setNome($nome)
    {
        $this->nome = $nome;
    }

    function setEmail($email)
    {
        $this->email = $email;
    }

    function setSenha($senha)
    {
        $this->senha = $this->encryptPassword($senha);
        return $this;
    }

    function setSalt($salt)
    {
        $this->salt = $salt;
    }

    function setGrupo($grupo)
    {
        $this->grupo = $grupo;
    }

    function setStatus($status)
    {
        $this->status = $status;
    }

    function setLogs($logs)
    {
        $this->logs = $logs;
    }

    public function encryptPassword($senha)
    {
        return base64_encode(Pbkdf2::calc('sha256', $senha, $this->salt, 10000, strlen($senha*2)));
    }

    public function __toString()
    {
        return $this->nome;
    }

    public function toArray()
    {
        return [
            'id'         => $this->getId(),
            'nome'       => $this->getNome(),
            'email'      => $this->getEmail(),
            'senha'      => $this->getSenha(),
            'salt'       => $this->salt,
            'grupo'      => $this->getGrupo()->getId(),
            'grupo_nome' => $this->getGrupo()->getNome(),
            'status'     => $this->getStatus()
        ];
    }
}
