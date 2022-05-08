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
            
        }        
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

        public function showResultAction(){
        if (!empty($_REQUEST['journee'])){
            $listResult = $this->userManager->getResultDay($_REQUEST['journee']);
            
        }
        $data = [
            'listResult' => $listResult
        ];
        $this->render('updateListScore', $data ); 
        // var_dump($_REQUEST);die;
     
    }

    public function editResultAction()
    {
        if( isset( $_REQUEST['id']) ) {
            $results = $this->userManager->get( (int)$_REQUEST['id']); 

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
                
                $data =[
                    "id"=>$_POST['id'],
                    "id_d"=>$_POST['id_d'],
                    "id_v"=>$_POST['id_v'],
                    "journee"=>$_POST['journee'],
                    "result_dom"=>(int)$_POST['result_d'],
                    "result_visiteur"=>(int)$_POST['result_v'],
                ];
                // var_dump($data);
                $results = new Results($data);
                // var_dump($results);
                $updateScore = $this->userManager->updateScore($results);
            }
        }
        $this->_listResult = $this->userManager->listResult();
        $dataScore = [
            'listResult'      => $this->_listResult, 
            // 'message'           => $message,
            'updateok'           => true,
            
        ];
        $this->render('gestionScore', $dataScore ); 
    }

}