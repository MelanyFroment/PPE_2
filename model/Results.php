<?php

namespace model;

class Results
{
    private $_id,
            $_id_d,
            $_id_v,
            $_journee,
            $_result_dom,
            $_result_visiteur;

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

    public function getId_d()
    {
        return $this->_id_d;
    }

    public function getId_v()
    {
        return $this->_id_v;
    }

    public function getJournee()
    {
        return $this->_journee;
    }
    
    public function getResult_dom()
    {
        return $this->_result_dom;
    }

    public function getResult_visiteur()
    {
        return $this->_result_visiteur;
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

    public function setId_d($id_d)
    {
        if(is_int($id_d)){
            $this->_id_d = $id_d;
        }
        
    }

    public function setId_v($id_v)
    {
        if(is_int($id_v)){
            $this->_id_v = $id_v;
        }
    }

    public function setJournee($journee)
    {
        if(is_int($journee)){
            $this->_journee = $journee;
        }
    }

    public function setResult_dom($result_dom)
    {
        if(is_int($result_dom)){
            $this->_result_dom = $result_dom;
        }
    }

     public function setResult_visiteur($result_visiteur)
    {
        if(is_int($result_visiteur)){
            $this->_result_visiteur = $result_visiteur;
        }
    }
}