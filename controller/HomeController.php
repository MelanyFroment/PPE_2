<?php

namespace controller;
use model\TeamManager;
use model\Team;



class HomeController extends Controller
{
    protected $gestionController;
    protected $userManager;

    public function __construct()
    {
        if (!isset($_SESSION['utilisateur'])) {
            header('Location: ?controller=connect');
        }        

        $this->userManager = new TeamManager();
        parent::__construct();
    }


    public function defaultAction()
    {
        // $clubs = $this->clubManager->getAll();
        // $this->render('home', [ 'listTeam' => $clubs ] );
        $this->gestionTeamAction();

    }

    public function gestionTeamAction(){
        $listTeam = $this->userManager->listTeam();        
        $data = ['listTeam' => $listTeam];
        $this->render('home', $data);
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

    public function editTeamAction()
    {
        if( isset( $_REQUEST['id']) ) {
            $listTeam = $this->userManager->get( (int)$_REQUEST['id']); 
            // var_dump($listTeam);
        }
        $data = [
            'listTeam'      => $listTeam,
            'updateok'  => true
        ];
        $this->render('updateListTeam', $data);
    }


    public function updateTeamAction()
    {
        if( isset( $_REQUEST['id'] ) ) {
            $team = $this->userManager->get( (int)$_REQUEST['id'] );

            if (isset($_REQUEST['name_team'], $_REQUEST['name_trainer'], $_REQUEST['logo'], $_REQUEST['team_information'])) {
                var_dump($_REQUEST['name_team']);
                $team->setName_team( $_REQUEST['name_team'] );
                $team->setName_trainer( $_REQUEST['name_trainer'] ); 
                $team->setLogo( $_REQUEST['logo'] );
                $team->setTeam_information( $_REQUEST['team_information'] ); 
            }
            if( $this->userManager->updateInfo( $team ) ) {
                $message = "L'??quipe <b>" . $team->getName_team() . " </b> a ??t?? modifi??."; 
            } else {
                $message = 'La modification a ??chou?? !';
            }
        }
        $this->_listTeam = $this->userManager->listTeam();
        $data = [
            'listTeam'      => $this->_listTeam,
            'message'           => $message,
            'updateok'           => true,
            
        ];
        $this->render('home', $data ); 
    }

    public function deleteTeamAction() //FINI
    {
        if( isset( $_REQUEST['id'] ) ) {
            $team = $this->userManager->get( (int)$_REQUEST['id'] );

            if( $this->userManager->deleteTeam( $team ) ) {
                $message = "L'??quipe <b>' . $team->getName_team() . '</b> a ??t?? supprim??.";
            } else {
                $message = 'La suppression a ??chou?? !';
            }
        }
        $this->_listTeam = $this->userManager->listTeam();
        $data = [
            'listTeam'      => $this->_listTeam,
            'message'           => $message,
            'delete'            => true 
        ];
        $this->render('home', $data );
    }

}