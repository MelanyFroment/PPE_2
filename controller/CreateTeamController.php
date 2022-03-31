<?php

namespace controller;

use model\TeamManager;
use model\Team;

class CreateTeamController extends Controller 
{

    protected $userManager;

    public function __construct()
    {
        if (isset($_SESSION['utilisateur'])) {
            header('Location: ?controller=home');
        }

        $this->userManager = new TeamManager();
        parent::__construct();
    }

    public function defaultAction()
    {
        $this->render('createTeam');
    } 

    public function createTeamAction()
    {
        var_dump($_POST);
        $newUser = new Team($_POST);
        $userData = $this->userManager->add($newUser);

        if (!empty($userData)) { 
            $this->render('createTeam', ['error' => true]);
        }
    }

}