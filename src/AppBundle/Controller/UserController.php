<?php

namespace AppBundle\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AdminController
{

    public function createNewUserEntity()
    {
        return $this->get('fos_user.user_manager')->createUser();
    }

    public function persistUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
        parent::persistEntity($user);
    }

    public function updateUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
        parent::updateEntity($user);
    }

    public function indexAction(Request $request)
    {
        $response = parent::indexAction($request);
        if ($this->entity['name'] == 'Administrateurs' and !$this->isGranted('ROLE_ADMIN')) {
            $this->get('session')->getFlashBag()->add('info', "Accès à l'interface administrateur refusé.");
            return $this->redirectToBackendHomepage();
        }
        /**
        elseif($this->entity['name'] == 'Prestations' and $this->request->get('action') == 'list'){
            return $this->redirectToBackendHomepage();

        }
         * */
        return $response;
    }

}



