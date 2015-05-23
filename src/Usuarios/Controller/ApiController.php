<?php

namespace Usuarios\Controller;

class ApiController extends \Base\Controller\ApiAbstractController
{
    public function __construct()
    {
        $this->service        = 'Usuarios\Service\Usuario';
        $this->controllerName = 'usuarios';
    }
}
