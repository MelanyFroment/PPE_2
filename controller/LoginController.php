<?php

namespace controller;


class ConnectController extends Controller
{

    // private $_nbPerso;

    public function __construct()
    {
        parent::__construct();

    }


    public function defaultAction()
    {
        // $persoManager = new PersonnagesManager();
        // $nbPerso = $persoManager->count();
        $data = ['test' => 'Ca marche']; // clé et la valeur 
        $this->render('login', $data);
    } 

}