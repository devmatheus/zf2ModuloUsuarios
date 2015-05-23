<?php

namespace Usuarios\Repository;

use Base\Entity\BaseRepository;

class UsuarioRepository extends BaseRepository
{

    public function findByEmailAndPassword($email, $password)
    {
        $user = $this->findOneByEmail($email);
        if ($user) {
            $hashSenha = $user->encryptPassword($password);
            if ($hashSenha == $user->getSenha()) {
                return $user;
            }
        }
        return false;
    }

}
