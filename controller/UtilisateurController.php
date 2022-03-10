<?php

namespace controller;

use model\Utilisateur;
use model\UtilisateurManager;


class UtilisateurController extends Controller
{

    protected $userManager;

    public function __construct()
    {
        if (!isset($_SESSION['utilisateur'])) {
            header('Location: ?controller=connect');
        }

        $this->userManager = new UtilisateurManager();
        parent::__construct();
    }
 
    public function defaultAction() 
    {
        $this->render('utilisateur');
    }

    

}