<?php

namespace controller;

use model\TeamManager;
use model\Team;


class GestionTeamController extends Controller 
{
    protected $gestionController;
    protected $userManager;


    public function __construct()
    {
        if (!isset($_SESSION['team'])) {
            header('Location: ?controller=connect');
        }

        $this->userManager = new TeamManager();
        parent::__construct(); 
        
    }
 
    public function defaultAction() 
    {
        $this->gestionTeamAction();
    }

    public function gestionTeamAction(){
        $listTeam = $this->userManager->listTeam();        
        $data = ['listTeam' => $listTeam];
        $this->render('home', $data);
    } 

    public function editTeamAction()
    {
        if( isset( $_REQUEST['id']) ) {
            $team = $this->userManager->get( (int)$_REQUEST['id']); 

        }
        $data = [
            'team'      => $team,
            'updateok'  => true
        ];
        $this->render('updateListTeam', $data);
    }


    public function updateTeamAction()
    {
        if( isset( $_REQUEST['id'] ) ) {
            $team = $this->userManager->get( (int)$_REQUEST['id'] );
            // var_dump($utilisateur);
            if (isset($_REQUEST['name_team'], $_REQUEST['name_trainer'], $_REQUEST['logo'], $_REQUEST['team_information'])) {
                $team->setName_team( $_REQUEST['name_team'] );
                $team->setName_trainer( $_REQUEST['name_trainer'] ); 
                $team->setLogo( $_REQUEST['logo'] );
                $team->setTeam_information( $_REQUEST['team_information'] ); 
            }
            // var_dump($utilisateur);
            if( $this->userManager->updateInfo( $team ) ) {
                $message = "L'équipe <b>" . $team->getName_team() . " </b> a été modifié."; 
            } else {
                $message = 'La modification a échoué !';
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
                $message = "L'équipe <b>' . $team->getName_team() . '</b> a été supprimé.";
            } else {
                $message = 'La suppression a échoué !';
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