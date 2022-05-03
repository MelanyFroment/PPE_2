<?php
namespace model; // Espace de nom / pas de conflit avec twig 

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
        // var_dump($journee);exit();
      if (is_int($journee))
      {
        $q = $this->manager
                  ->db
                  ->prepare('SELECT * FROM `results` WHERE journee = :journee'); // Fonction PDO = prepare('') // Ne pas mettre les valeur direct ppour une meilleur securité // On enregistre ne bdd

                //   ->prepare("SELECT
                //   results.id_d,
                //   results.id_v,
                //   results.result_d,
                //   teams.name_team AS team_d
                //   FROM results JOIN teams
                //   ON results.id_d = teams.id
                //   WHERE journee =  journee");
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
       /* $q = $this->_db->query('SELECT id, nom, degats FROM personnages WHERE id = '.$info);*/
        $q = $this->manager
                  ->db
                  ->prepare('SELECT * FROM results WHERE journee = :journee' );
         $q->execute([':journee' => $info]);
         $donnees = $q->fetch(\PDO::FETCH_ASSOC);
      //    var_dump($donnees);exit(); 
          if ($donnees){
              return $donnees;
          }else{
              return false;
          }
      }
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

    public function updateInfo(Results $Results)
    {
        $q = $this->manager
            ->db
            ->prepare('UPDATE results SET 
                        id_d = :id_d,
                        id_v = :id_v,
                        result_d = :result_d,
                        result_v = :result_v,
                        journee = :journee
                        WHERE id = :id'); 

        $ret = $q->execute( [
            ':id_d'  => $Results->getId_d(), 
            ':id_v'  => $Results->getId_v(), 
            ':journee'  => $Results->getJournee(), 
            ':result_d'  => $Results->getresult_dom(), 
            ':result_v'   => $Results->getResult_visiteur(),
            ':id' =>$Results->getId()
        ]);
        return $ret;
        //   $q->debugDumpParams();
    }

    // public function getNameTeam($id){
    //     $q = $this->manager
    //               ->db
    //               ->prepare('SELECT * FROM results WHERE journee = :journee' );
    //         $q->execute([':journee' => $journee]);
    //         $donnees = $q->fetchAll(\PDO::FETCH_ASSOC);
    // }
}