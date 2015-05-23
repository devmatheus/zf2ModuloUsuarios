<?php

namespace Usuarios\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Session\Container as SessionContainer;
use Usuarios\Form\Login as LoginForm;
use Log\Entity\Log as Log;

class AuthController extends AbstractActionController
{
    public function indexAction()
    {
        $sessionContainer = new SessionContainer('auth_config');
        
        $form = new LoginForm;
        $error = false;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $request->getPost()->toArray();

                $auth = new AuthenticationService;

                $sessionStorage = new SessionStorage('admin');
                $auth->setStorage($sessionStorage);

                $authAdapter = $this->getServiceLocator()
                                    ->get('Usuarios\Auth\Adapter');
                $authAdapter->setEmail($data['email'])
                            ->setPassword($data['password']);

                $result = $auth->authenticate($authAdapter);

                $identity = $auth->getIdentity();
                if ($result->isValid()) {
                    $sessionStorage->write($identity['user'], null);
                    $this->log(Log::ACAO_LOGIN);
                    
                    if ($sessionContainer->urlAnterior) {
                        return $this->redirect()->toUrl($sessionContainer->urlAnterior);
                    }
                    return $this->redirect()->toRoute('home-admin');
                } else {
                    $error = true;
                }
            }
        }

        return new ViewModel(array('form' => $form, 'error' => $error, 'tentativasLogin' => $sessionContainer->tentativasLogin));
    }

    public function logoutAction()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new SessionStorage('admin'));
        $identity = $auth->getIdentity();
        $this->log(Log::ACAO_LOGOUT, $identity['id']);
        $auth->clearIdentity();
        return $this->redirect()->toRoute('admin-auth');
    }

    public function log($acao, $usuario_id = null)
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        if (!$usuario_id) {
            $auth = new AuthenticationService();
            $auth->setStorage(new SessionStorage('admin'));
            $usuarioSession = $auth->getIdentity();
            $usuarioEntity = $em->getReference('Usuarios\Entity\Usuario', $usuarioSession['id']);
        } else {
            $usuarioEntity = $em->getReference('Usuarios\Entity\Usuario', $usuario_id);
        }

        $entity = new \Log\Entity\Log([
            'acao'     => $acao,
            'entity'   => 'Usuario\Entity\Usuario',
            'usuario'  => $usuarioEntity,
            'dataHora' => new \Datetime('now')
        ]);
        
        $em->persist($entity);
        $em->flush();
    }
}
