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
            $userData = $this->userManager->getUtilisateur($_POST['username']);
            $verifepassword = sodium_crypto_pwhash_str_verify($userData['password'],$_POST['password'] );
            $getCount = $this->userManager->getCount($_POST['username']);
            // var_dump($getCount);die;
            if ($getCount == 1  &&  $verifepassword == true ) {
                $_SESSION['utilisateur'] = $userData;

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