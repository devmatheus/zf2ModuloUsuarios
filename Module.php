<?php

namespace Usuarios;

class Module
{
	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig()
	{
		return [
			'Zend\Loader\ClassMapAutoloader' => [
				__DIR__ . '/autoload_classmap.php'
			]
		];
	}

	public function getServiceConfig()
	{
		return [
			'factories' => [
				'Usuarios\Service\Usuario'  => function ($service) {
					return new Service\Usuario($service->get('Doctrine\ORM\EntityManager'));
				},
				'Usuarios\Auth\Adapter' => function ($service) {
					return new Auth\Adapter($service->get('Doctrine\ORM\EntityManager'), $service->get('Config'));
				},
				'Usuarios\Form\Usuario' => function ($service) {
					$em = $service->get('Doctrine\ORM\EntityManager');
					$grupos = $em->getRepository('Acl\Entity\Grupo')->fetchPairs();

					return new Form\Usuario($grupos);
				},
				'Usuarios\Formatter\Status' => function () {
					return new Formatter\Status;
				}
			]
		];
	}

	public function getViewHelperConfig()
	{
		return [
			'invokables' => [
				'UserIdentity' => 'Usuarios\View\Helper\UserIdentity'
			]
		];
	}
}
