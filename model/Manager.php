<?php
namespace model;

use classes\dbConnect;

class Manager
{
    private $_dsn = 'mysql:host=localhost;dbname=ppe2_melany';
    private $_login = 'melany';
    private $_password = '3ceVFyXEe';

    /** 
     * Attribut contenant l'instance PDO 
     */
    protected $manager;


    public function __construct()
    {
        $this->manager = dbConnect::getDb($this->_dsn, $this->_login, $this->_password ); //Toutes les requete faite avec $this->manager
    }

}
