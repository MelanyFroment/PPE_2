<?php

namespace model; 


class Team
{
    private $_id,
            $_name_team,
            $_name_trainer,
            $_logo,
            $_team_information;

    
    
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

    public function getName_team()
    {
        return $this->_name_team;
    }

    public function getName_trainer()
    {
        return $this->_name_trainer;
    }

    public function getLogo()
    {
        return $this->_logo;
    }
    
    public function getTeam_information()
    {
        return $this->_team_information;
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

    public function setName_team($name_team)
    {
        if (!empty($name_team) && is_string($name_team) ){
            $this->_name_team = $name_team;
        }
    }

    public function setName_trainer($name_trainer)
    {
        if (!empty($name_trainer) && is_string($name_trainer) ){
            $this->_name_trainer = $name_trainer;
        }
    }
    
    public function setLogo($logo)
    {
        if (!empty($logo) && is_string($logo) ){
            $this->_logo = $logo;
        }
    }
    
    public function setTeam_information($team_information)
    {
        if (!empty($team_information) && is_string($team_information) ){
            $this->_team_information = $team_information;
        }
    }
}