<?php
namespace model; // Espace de nom / pas de conflit avec twig 

use LDAP\Result;
use model\Results;
use PDO; // Class native 

class ResultsManager extends Manager
{
    public function add(Results $Results)
    {
        $q = $this->manager
            ->db    
                ->prepare('INSERT INTO results (id_d,id_v,journee,result_d,result_v) VALUES (:id_d, :id_v, :journee, :result_d,result_v )'); // Fonction PDO = prepare('') // Ne pas mettre les valeur direct ppour une meilleur securité // On enregistre ne bdd
        $q->execute([
            ':id_d' => $Results->getId_d(),
            ':id_v' => $Results->getId_v(),
            ':journee' => $Results->getJournee(),
            ':result_d' => $Results->getResult_dom(),
            ':result_v' => $Results->getResult_visiteur(),
        ]); 

        $Results->hydrate([ // On recupere l'Id gracee a la fonction hydrate pour recupere les champs
            'id' => $this->manager->db->lastInsertId()
        ]);
        return $Results;
    }

    public function count()
    {
      $cpt = $this->manager
                  ->db
                  ->query('SELECT COUNT(*) FROM results')->fetchColumn();
      return $cpt;
    }

    public function getResultDay(int $journee)
    {
      if (is_int($journee))
      {
        $q = $this->manager
                  ->db
                  ->prepare('SELECT results.id_d, results.id_v, results.result_d, teams.name_team FROM results JOIN teams ON results.id_d = teams.id WHERE journee = results.journee');
                //   ->prepare('SELECT * FROM `results` WHERE journee = :journee'); // Fonction PDO = prepare('') // Ne pas mettre les valeur direct ppour une meilleur securité // On enregistre ne bdd

         $q->execute([':journee' => $journee]);
         $donnees = $q->fetchAll(\PDO::FETCH_ASSOC);
        //  var_dump($donnees);exit();
          if ($donnees){ 
              return $donnees;
          }else{ 
              return false;
          }
      }
    }

    public function get($info)
    {
      if (is_int($info))
      {
        $q = $this->manager
                  ->db
                  ->prepare('SELECT * FROM results WHERE id = :id' );
         $q->execute([':id' => $info]);
         $donnees = $q->fetch(\PDO::FETCH_ASSOC);
        //  var_dump($donnees);exit(); 
          if ($donnees){
              return $donnees;
          }else{
              return false;
          }
      }
    }

    public function updateInfo(Results $Results)
    {
        $q = $this->manager
            ->db
            ->prepare('UPDATE results SET 
                        result_d = :result_d,
                        result_v = :result_v,
                        WHERE id = :id'); 
        $q->bindValue(':id', $Results->getId(), PDO::PARAM_INT);
        $q->bindValue(':result_d', $Results->getResult_dom(), PDO::PARAM_INT);
        $q->bindValue(':result_v', $Results->getResult_visiteur(), PDO::PARAM_INT);
        $ret = $q->execute();
        // $q->debugDumpParams();


        // $ret = $q->execute( [
        //     ':id' =>$Results->getId(),
        //     ':id_d'  => $Results->getId_d(), 
        //     ':id_v'  => $Results->getId_v(), 
        //     ':journee'  => $Results->getJournee(), 
        //     ':result_d'  => $Results->getresult_dom(), 
        //     ':result_v'   => $Results->getResult_visiteur(),
            
        // ]);
        // return $ret;
        //   $q->debugDumpParams();
    }

    public function updateScore(Results $results)
    {
        // var_dump($username);
        $q = $this->manager
                ->db
                ->prepare('UPDATE results SET 
                result_d = :result_d,
                result_v = :result_v
                WHERE id = :id');
     $ret = $q->execute( [
         ':id'   => $results->getId(),
        ':result_d'  => $results->getResult_dom(), 
        ':result_v'  => $results->getResult_visiteur(), 
         
    ]);
    // $q->debugDumpParams();

    return $ret;
    }
    
    public function listResult()
    {
        $users = [];
        $q = $this->manager 
            ->db    
                ->prepare('SELECT * FROM `results` ');
        $q->execute();
        $listUser = $q->fetchAll(PDO::FETCH_ASSOC);
        return $listUser;
    }
}