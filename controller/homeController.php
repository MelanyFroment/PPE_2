<?php

namespace controller;


class HomeController extends Controller
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
        $data = [
            'username' => 'connecter',
            
        ]; // clé et la valeur 
        $this->render('home', $data);
    }

}