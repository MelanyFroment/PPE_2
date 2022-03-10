<?php
namespace controller;


abstract class Controller
{
    protected $twig;
    protected $pathView = 'view';

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('view',);
        $this->twig = new \Twig\Environment($loader ,
        [
            'debug' => true
        ]);
        $this ->twig->addExtension(new \Twig\Extension\DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);

        if( isset( $_GET['action'] ) ) {
            $action = $_GET['action'] . 'Action';
            $this->$action();
        } else {
            $this->defaultAction();
        }
    }

    /**
     * Action par défaut du contrôleur
     */
    abstract public function defaultAction();


    protected function render($view, $data=[])
    {
        // extract( $data );


        $fileName =  $view . 'View.twig';
        $filePath = $this->pathView . '/' . $fileName;

        if( file_exists( $filePath ) ) {
            echo $this->twig->render( $fileName, $data );
            //require_once $fileName;
        } else {
            exit( "View file not exist !" );
        }
    }
}