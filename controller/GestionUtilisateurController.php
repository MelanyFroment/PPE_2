<?php

namespace controller;

use model\UtilisateurManager;
use model\Utilisateur;


class GestionUtilisateurController extends Controller 
{
    protected $gestionController;
    protected $userManager;


    public function __construct()
    {
        if (!isset($_SESSION['utilisateur'])) {
            $this->userManager = $_SESSION['utilisateur'];


            header('Location: ?controller=connect');
        }

        $this->userManager = new UtilisateurManager();
        parent::__construct(); 
        
    }
 
    public function defaultAction() 
    {
        $this->gestionUtilisateurAction();
    }

    public function gestionUtilisateurAction(){
        $listUser = $this->userManager->listUser();        
        $data = ['listUser' => $listUser];
        $this->render('gestionUtilisateur', $data);
    } 
 
    public function editUtilisateurAction()
    {
        if( isset( $_REQUEST['id']) ) {
            $utilisateur = $this->userManager->get( (int)$_REQUEST['id']); 

        }
        $data = [
            'utilisateur' => $utilisateur,
            'updateok'           => true
        ];
        $this->render('updateListPerso', $data);
    }


    public function updateUtilisateurAction()
    {
        if( isset( $_REQUEST['id'] ) ) {
            $utilisateur = $this->userManager->get( (int)$_REQUEST['id'] );
            // var_dump($utilisateur);
            if (isset($_REQUEST['username'], $_REQUEST['nom'], $_REQUEST['prenom'], $_REQUEST['active'])) {
                $utilisateur->setUsername( $_REQUEST['username'] );
                $utilisateur->setNom( $_REQUEST['nom'] );
                $utilisateur->setPrenom( $_REQUEST['prenom'] );
                $utilisateur->setActive( $_REQUEST['active'] ); 
            }
            // var_dump($utilisateur);
            if( $this->userManager->updateInfo( $utilisateur ) ) {
                $message = "Le personnage <b>" . $utilisateur->getUsername() . " </b> a été modifié."; 
            } else {
                $message = 'La modification a échoué !';
            }
        }
        $this->_listUser = $this->userManager->listUser();
        $data = [
            'listUser'      => $this->_listUser,
            'message'           => $message,
            'updateok'           => true,
            
        ];
        $this->render('gestionUtilisateur', $data ); 
    }

    public function deleteUtilisateurAction() //FINI
    {
        if( isset( $_REQUEST['id'] ) ) {
            $utilisateur = $this->userManager->get( (int)$_REQUEST['id'] );

            if( $this->userManager->deleteUtilisateur( $utilisateur ) ) {
                $message = 'Le personnage <b>' . $utilisateur->getNom() . '</b> a été supprimé.';
            } else {
                $message = 'La suppression a échoué !';
            }
        }
        $this->_listUser = $this->userManager->listUser();
        $data = [
            'listUser'      => $this->_listUser,
            'message'           => $message,
            'delete'            => true 
        ];
        $this->render('gestionUtilisateur', $data );
    }
}