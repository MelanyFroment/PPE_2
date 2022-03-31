<?php
namespace model; // Espace de nom / pas de conflit avec twig 

use model\Team;
use PDO; // Class native 

class TeamManager extends Manager
{
    public function add(Team $Team)
    {
        $q = $this->manager
            ->db    
                ->prepare('INSERT INTO teams (name_team,name_trainer,logo,team_information) VALUES (:name_team, :name_trainer, :logo, :team_information)'); // Fonction PDO = prepare('') // Ne pas mettre les valeur direct ppour une meilleur securité // On enregistre ne bdd
        $q->execute([
            ':name_team' => $Team->getName_team(),
            ':name_trainer' => $Team->getName_trainer(),
            ':logo' => $Team->getLogo(),
            ':team_information' => $Team->getTeam_information(),
        ]); 

        $Team->hydrate([ // On recupere l'Id gracee a la fonction hydrate pour recupere les champs
            'id' => $this->manager->db->lastInsertId()
        ]);
        return $Team;
    }

    public function count()
    {
      $cpt = $this->manager
                  ->db
                  ->query('SELECT COUNT(*) FROM teams')->fetchColumn();
      return $cpt;
    }

    public function getTeam($name_team)
    {
        $q = $this->manager 
            ->db    
                ->prepare('SELECT * FROM `teams` WHERE name_team = :name_team'); // Fonction PDO = prepare('') // Ne pas mettre les valeur direct ppour une meilleur securité // On enregistre ne bdd
        $q->execute([
            ':name_team' => $name_team
        ]);
    
        $userData = $q->fetch();
        return $userData; 
    }

    public function get($info)
  {
    if (is_int($info))
    {
     /* $q = $this->_db->query('SELECT id, nom, degats FROM personnages WHERE id = '.$info);*/
      $q = $this->manager
                ->db
                ->prepare('SELECT * FROM teams WHERE id = :id' );
       $q->execute([':id' => $info]);
       $donnees = $q->fetch(\PDO::FETCH_ASSOC);
    //    var_dump($donnees);exit();
            
      return new Team($donnees);
    }
  }

  public function updateInfo(Team $team)
  {
      $q = $this->manager
          ->db
          ->prepare('UPDATE teams SET 
                     name_team = :name_team,
                     name_trainer = :name_trainer,
                     logo = :logo,
                     team_information = :team_information
                     WHERE id = :id');

      $ret = $q->execute( [
          ':name_team'  => $team->getname_team(), 
          ':name_trainer'  => $team->getname_trainer(), 
          ':logo'  => $team->getLogo(), 
          ':team_information'  => $team->getTeam_information(), 
          ':id'   => $team->getId()
      ]);
      return $ret;
    //   $q->debugDumpParams();
  }


    public function updateTeam(Team $team)
    {
        // var_dump($username);
        $q = $this->manager
                ->db
                ->prepare('UPDATE teams SET 
                name_team = :username
                name_trainer = :nom,
                logo = :prenom,
                team_information = :team_information,
                id = :active
                WHERE id = :id');
     $ret = $q->execute( [
        ':name_team'  => $team->getName_team(),
        ':name_trainer'  => $team->getName_trainer(),
        ':logo'  => $team->getLogo(),
        ':team_information'  => $team->getTeam_information(), 
        ':id'   => $team->getId()
    ]);
    return $ret;
    }

    public function deleteTeam(Team $team)
    {
        // var_dump($utilisateur);
        return $this->manager
                ->db
                ->exec('DELETE FROM teams WHERE id = '.$team->getId());
    }

    public function listTeam()
    {
        $teams = [];
        $q = $this->manager 
            ->db    
                ->prepare('SELECT * FROM `teams`');
        $q->execute();
        $listTeam = $q->fetchAll(PDO::FETCH_ASSOC);
        return $listTeam; 
    }
}