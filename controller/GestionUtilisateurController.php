<?php

namespace controller;

use model\Utilisateur;
use model\UtilisateurManager;


class GestionUtilisateurController extends Controller
{
    protected $gestionController;

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
        $this->gestionUtilisateurAction();
    }

    public function gestionUtilisateurAction(){
       
        $listUser = $this->userManager->listUser();
        $data = ['listUser' => $listUser];
        $this->render('gestionUtilisateur', $data);
        // var_dump($data);
    } 


    public function updateUtilisateurAction()
    {
        if( isset( $_REQUEST['valider'] ) ) {
            if( $ok = $this->userManager->updateUtilisateur( $_REQUEST ) ) {
                
            }
        } elseif( isset( $_REQUEST['id'] ) ) {
            $utilisateur = $this->userManager->get( (int)$_REQUEST['id'] );
            $data = [
                'utilisateur'      => $utilisateur,
            ];
            $this->render('updateUtilisateur', $data ); // Formulaire a créer 
        }
    }

    public function deleteUtilisateurAction()
    {
        if( isset( $_REQUEST['id'] ) ) {
            $utilisateur = $this->persoManager->get( (int)$_REQUEST['id'] );

            if( $this->persoManager->delete( $utilisateur ) ) {
                $message = 'Le personnage <b>' . $utilisateur->getNom() . '</b> a été supprimé.';
            } else {
                $message = 'La suppression a échoué !';
            }
        }
        $this->_listPerso = $this->persoManager->getAllListPerso();
        $data = [
            'listAllPerso'      => $this->_listPerso,
            'message'           => $message,
            'delete'            => true
        ];
        $this->render('listperso', $data );
    }
}