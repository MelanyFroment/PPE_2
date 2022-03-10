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
        var_dump($_POST);
        $newUser = new Utilisateur($_POST);
        $userData = $this->userManager->add($newUser);

        if (!empty($userData)) { 
            $this->render('create', ['error' => true]);
        }
    }

}