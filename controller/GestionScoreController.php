<?php

namespace controller;

use LDAP\Result;
use model\ResultsManager;
use model\Results;




class GestionScoreController extends Controller
{
    protected $gestionController;
    protected $userManager;

    public function __construct() 
    {
        $this->userManager = new ResultsManager();
        parent::__construct();
        if (!isset($_SESSION['utilisateur'])) {
            // $this->resultManager = $_SESSION['utilisateur'];

            // header('Location: ?controller=connect');
        }        

        // $this->resultManager = new ResultsManager(); 
        // parent::__construct();
    }

    public function defaultAction() 
    {
        $this->gestionScoreAction();

    }

    public function gestionScoreAction(){
        $listResult = $this->userManager->listResult();  
      
        $data = ['listResult' => $listResult];
        $this->render('gestionScore', $data);    
    } 

    //Editer les résultats
    // public function showResultAction(){
    //     if (!empty($_REQUEST['journee'])){
    //         $listResult = $this->userManager->getResultDay($_REQUEST['journee']);
            
    //     }
    //     $data = [
    //         'listResult' => $listResult
    //     ];
    //     $this->render('updateListScore', $data ); 
    //     // var_dump($_REQUEST);die;
     
    // }

    public function editResultAction()
    {
        if( isset( $_REQUEST['id']) ) {
            $results = $this->userManager->getResultDay( (int)$_REQUEST['id']); 

        }
        $data = [
            'result'      => $results,
            'updateok'  => true
        ];
        $this->render('updateListScore', $data);
    }

    public function updateScoreAction()
    {
        if( isset( $_REQUEST['id'] ) ) {
            $dataScore = $this->userManager->getResultDay( (int)$_REQUEST['id'] );

            if (isset($_REQUEST['id_d'], $_REQUEST['id_v'], $_REQUEST['journee'], $_REQUEST['result_d'],  $_REQUEST['result_v'])) {
                
                $results = new Results( $dataScore );
                $results->setId_d( $_REQUEST['id_d'] );
                $results->setId_v( $_REQUEST['id_v'] ); 
                $results->setJournee( $_REQUEST['journee'] );
                $results->setResult_dom( $_REQUEST['result_d'] );
                $results->setResult_visiteur( $_REQUEST['result_v'] ); 
            }
            // var_dump((int)$_REQUEST['id']);exit;
            // if( $this->userManager->updateInfo( $results ) ) {
            //     $message = "L'équipe <b>" . $results->getid_d() . " </b> vs ". $results->getid_v() ." a été modifié."; 
            // } else {
            //     $message = 'La modification a échoué !';
            // }
        }
        $this->_listResult = $this->userManager->listResult();
        $dataScore = [
            'listResult'      => $this->_listResult, 
            // 'message'           => $message,
            'updateok'           => true,
            
        ];
        $this->render('gestionScore', $dataScore ); 
    }

    // public function editScoreAction()
    // {
    //     if( isset( $_REQUEST['id']) ) {
    //         $score = $this->userManager->get( (int)$_REQUEST['id']); 

    //     }
    //     $data = [
    //         'score'      => $score,
    //         'updateok'  => true
    //     ];
    //     $this->render('updateListTeam', $data);
    // }


}