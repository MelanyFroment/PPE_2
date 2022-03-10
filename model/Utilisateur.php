<?php

namespace model; 


class Utilisateur
{
    private $_id,
            $_prenom,
            $_nom,
            $_username,
            $_password,
            $_admin,
            $_active,
            $_observateur;

    
    
    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    //Sert a remplir l'objet 
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value)
        {
        $method = 'set'.ucfirst($key);
        
            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }

    // GETTERS // //Recuperer 
        public function getId()
    {
        return $this->_id;
    }

    public function getPrenom()
    {
        return $this->_prenom;
    }

    public function getNom()
    {
        return $this->_nom;
    }

    public function getUsername()
    {
        return $this->_username;
    }
    
    public function getPassword()
    {
        return $this->_password;
    }

    public function getAdmin()
    {
        return $this->_admin;
    }

    public function getActive()
    {
        return $this->_active;
    }

    public function getObservateur()
    {
        return $this->_observateur;
    }


    // SETTERS // //Assigner
    public function setId($id)
    {
        $id = (int) $id;
        
        if ($id > 0)
        {
            $this->_id = $id;
        }
    }

    public function setPrenom($prenom)
    {
        if (!empty($prenom) && is_string($prenom) ){
            $this->_prenom = $prenom;
        }
    }

    public function setNom($nom)
    {
        if (!empty($nom) && is_string($nom) ){
            $this->_nom = $nom;
        }
    }
    
    public function setMail($mail)
    {
        if (!empty($mail) && is_string($mail) ){
            $this->_mail = $mail;
        }
    }
    
    public function setUsername($username)
    {
        if (!empty($username) && is_string($username) ){
            $this->_username = $username;
        }
    }
    
    public function setPassword($password)
    {
        if (!empty($password) && is_string($password) ){
            $this->_password = $password; 
        }
    }

    public function setAdmin($admin)
    {
        if (in_array($admin, [0, 1, 2])) {
            $this->_admin = $admin; 
        }
    }


    public function setActive($active)
    {
        if (in_array($active, [0, 1, 2])){
            $this->_active = $active; 
        }
    }

    public function setObservateur($observateur)
    {
        if (!empty($observateur) && is_string($observateur) ){
            $this->_observateur = $observateur; 
        }
    }
}