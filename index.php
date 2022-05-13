<?php
session_start(); // On appelle session_start() APRÈS avoir enregistré l'autoload.

// $getpassword=sodium_crypto_pwhash_str('P3r5&L*C' ,SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE);
// echo $getpassword;die;

ini_set( 'display_errors', 1 );
error_reporting( E_ALL );

require 'autoload.php';
require 'vendor/autoload.php';

/*
$loader = new \Twig\Loader\FilesystemLoader('view');
$twig = new \Twig\Environment($loader);

$monTableau = ['nom'=>'Frati', 'prenom'=>'Fred'];
$data = [
    'title' => 'Mon super blog',
    'monTableau' => $monTableau
];

echo $twig->render( 'test.twig', $data );
die;*/


$controllerPath = "controller"; 

if( isset( $_GET['controller'] ) ) {
  $controllerName = ucfirst($_GET['controller']);
} else {
  $controllerName = 'Home';
}
$fileName = 'controller/' . $controllerName . 'Controller.php';
$className = $controllerPath . '\\' . $controllerName . 'Controller';


if( file_exists( $fileName ) ) {
  if( class_exists( $className ) ) {
    $controller = new $className();
  } else {
    exit( "Error : Class not found!" );
  }
} else {
  exit( "Error 404 : not found!" );
}

?>






