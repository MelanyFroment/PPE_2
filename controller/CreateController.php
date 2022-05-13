<?php

namespace controller;

use model\UtilisateurManager;
use model\Utilisateur;

class CreateController extends Controller
{

    protected $userManager;

    public function __construct()
    {
        if (isset($_SESSION['utilisateur'])) {
            // var_dump($_SESSION);die;
            header('Location: ?controller=home');
        }

        $this->userManager = new UtilisateurManager();
        parent::__construct();
    }

    public function defaultAction()
    {
        $this->render('create');
    } 

    public function createAction()
    {
        $dataUser = [
            'prenom' => $_POST['prenom'],
            'nom' => $_POST['nom'],
            'username' => $_POST['username'],
            'admin' => $_POST['admin'],
            'active' => $_POST['active'],
            'observateur' => $_POST['observateur'],
            'password' =>  $getpassword=sodium_crypto_pwhash_str($_POST['password'],SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE),

        ];                           
        var_dump($dataUser);
        $newUser = new Utilisateur($dataUser);
        $userData = $this->userManager->add($newUser);

        if (!empty($userData)) { 
            $this->render('connect', ['error' => true]); 
        }
    }

}