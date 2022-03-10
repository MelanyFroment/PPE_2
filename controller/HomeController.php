<?php

namespace controller;


class HomeController extends Controller
{

    public function __construct()
    {
        if (!isset($_SESSION['utilisateur'])) {
            header('Location: ?controller=connect');
        }        
        parent::__construct();
    }


    public function defaultAction() 
    {
        // $clubs = $this->clubManager->getAll();
        $this->render('home'/*, [ 'clubs' => $clubs ] */);
    }

}