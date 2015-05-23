<?php

namespace Usuarios\Formatter;

use Base\Formatter\Formatter;
use Usuarios\Entity\Usuario as UsuarioEntity;

class Status implements Formatter
{
    function set($value)
    {
        $this->value = $value;
        return $this;
    }
    
    function get()
    {
        return UsuarioEntity::$translate['status'][$this->value];
    }
}
