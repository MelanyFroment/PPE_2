<?php

namespace controller;

use model\UtilisateurManager;
use model\Utilisateur;

class ConnectController extends Controller
{

    protected $userManager;

    public function __construct()
    {
        if (isset($_SESSION['utilisateur'])) {
            header('Location: ?controller=home');
        }

        $this->userManager = new UtilisateurManager();
        parent::__construct();
    }


    public function defaultAction()
    {
        $this->render('connect');
    } 

    public function loginAction()  
    {
        if ( !empty( $_POST['username']) && !empty( $_POST['password'])) {
            // var_dump($_POST);
            
            $userData = $this->userManager->getUtilisateur($_POST['username'], $_POST['password']);
            // var_dump($userData);

            if (!empty($userData)) {
                $_SESSION['utilisateur'] = $userData;
                // var_dump($_SESSION);die;

                header('Location: ?controller=home');
            }
            
        }
    
        $this->render('connect', ['error' => true]);
    }

    
    public function logoutAction()
    {
        session_destroy();
        unset($_SESSION);
        header('Location: .');
        exit();
    }

}