<?php

return array(
    'entities' => array(
        'Usuarios\Entity\Usuario' => 'Usuarios\Entity\Usuario'
    ),
    'services' => array(
        'Usuarios\Service\Usuario' => 'Usuarios\Service\Usuario'
    ),
    'forms' => array(
        'Usuarios\Form\Usuario' => 'Usuarios\Form\Usuario'
    ),
    'router' => array(
        'routes' => array(
            'admin-usuarios' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/admin/usuarios[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-z0-9_-]*',
                        'id' => '\d+'
                    ),
                    'defaults' => array(
                        'controller' => 'admin/usuarios'
                    )
                )
            ),
            'api-usuarios'  => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/admin/usuarios/api[/:id]',
                    'constraints' => array(
                        'id' => '\d+'
                    ),
                    'defaults' => array(
                        'controller' => 'api/usuarios'
                    )
                )
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'admin/usuarios' => 'Usuarios\Controller\IndexController',
            'api/usuarios'   => 'Usuarios\Controller\ApiController',
            'admin/auth'     => 'Usuarios\Controller\AuthController'
        )
    ),
    'doctrine' => array(
        'driver' => array(
            'Usuarios_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Usuarios/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Usuarios\Entity' => 'Usuarios_driver'
                )
            )
        )
    ),
    'module_layouts' => array(
        'Usuarios' => 'layout/admin'
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view'
        ),
        'template_map' => array(
            'view-admin/auth' => __DIR__ . '/../view/auth/index.phtml'
        )
    ),
    'navigation' => array(
        'default' => array(
            'configuracoes' => array(
                'pages' => array(
                    'usuarios' => array(
                        'label' => 'Usuários',
                        'route' => '#',
                        'pages' => array(
                            'lista' => array(
                                'label'  => 'Lista de registros',
                                'route'  => 'admin-usuarios',
                                'action' => 'index'
                            ),
                            'novo' => array(
                                'label'  => 'Novo registro',
                                'route'  => 'admin-usuarios',
                                'action' => 'novo'
                            )
                        )
                    )
                )
            )
        )
    )
);
