<?php
namespace model; // Espace de nom / pas de conflit avec twig 

use model\Utilisateur;
use PDO; // Class native 

class UtilisateurManager extends Manager // UtilisateurManager herite de manager 
{
    public function add(Utilisateur $utilisateur)
    {
        $q = $this->manager
            ->db    
                ->prepare('INSERT INTO utilisateur (nom,prenom,username,password,admin,active,observateur) VALUES (:nom, :prenom, :username, :password, :admin, :active, :observateur)'); // Fonction PDO = prepare('') // Ne pas mettre les valeur direct ppour une meilleur securité // On enregistre ne bdd
        $q->execute([
            ':nom' => $utilisateur->getNom(),
            ':prenom' => $utilisateur->getPrenom(),
            ':username' => $utilisateur->getUsername(),
            ':password' => $utilisateur->getPassword(),
            ':admin' => $utilisateur->getAdmin(),
            ':active' => $utilisateur->getActive(),
            ':observateur' => $utilisateur->getObservateur()
        ]); 

        $utilisateur->hydrate([ // On recupere l'Id gracee a la fonction hydrate pour recupere les champs
            'id' => $this->manager->db->lastInsertId()
        ]);
        return $utilisateur;
    }

    public function count()
    {
      $cpt = $this->manager
                  ->db
                  ->query('SELECT COUNT(*) FROM utilisateur')->fetchColumn();
      return $cpt;
    }

    public function getUtilisateur($username, $password)
    {
        $q = $this->manager 
            ->db    
                ->prepare('SELECT * FROM `utilisateur` WHERE username = :username AND password = :password'); // Fonction PDO = prepare('') // Ne pas mettre les valeur direct ppour une meilleur securité // On enregistre ne bdd
        $q->execute([
            ':username' => $username,
            ':password' => $password
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
                ->prepare('SELECT * FROM utilisateur WHERE id = :id' );
       $q->execute([':id' => $info]);
       $donnees = $q->fetch(\PDO::FETCH_ASSOC);
    //    var_dump($donnees);exit();
            
      return new Utilisateur($donnees);
    }
  }

  public function updateInfo(Utilisateur $username)
  {
      $q = $this->manager
          ->db
          ->prepare('UPDATE utilisateur SET 
                     username = :username,
                     nom = :nom,
                     prenom = :prenom,
                     active = :active
                     WHERE id = :id');

      $ret = $q->execute( [
          ':username'  => $username->getUsername(), 
          ':nom'  => $username->getNom(), 
          ':prenom'  => $username->getPrenom(), 
          ':active'  => $username->getActive(), 
          ':id'   => $username->getId()
      ]);
      return $ret;
    //   $q->debugDumpParams();
  }


    public function updateUtilisateur(Utilisateur $utilisateur)
    {
        // var_dump($username);
        $q = $this->manager
                ->db
                ->prepare('UPDATE utilisateur SET 
                username = :username
                nom = :nom,
                prenom = :prenom,
                active = :active
                WHERE id = :id');
     $ret = $q->execute( [
        ':username'  => $utilisateur->getUsername(),
        ':nom'  => $utilisateur->getNom(),
        ':prenom'  => $utilisateur->getPrenom(),
        ':active'  => $utilisateur->getActive(),
        ':id'   => $utilisateur->getId()
    ]);
    return $ret;
    }

    public function deleteUtilisateur(Utilisateur $utilisateur)
    {
        var_dump($utilisateur);
        return $this->manager
                ->db
                ->exec('DELETE FROM utilisateur WHERE id = '.$utilisateur->getId());
    }

    public function listUser()
    {
        $users = [];
        $q = $this->manager 
            ->db    
                ->prepare('SELECT * FROM `utilisateur` WHERE admin = 0');
        $q->execute();
        $listUser = $q->fetchAll(PDO::FETCH_ASSOC);
        return $listUser;
    }


//     public function count()
//     {
//         $cpt = $this->manager
//                     ->db
//                     ->query('SELECT COUNT(*) FROM utilisateur')->fetchColumn();
//         return $cpt;
//     }

//     public function delete(Utilisateur $perso)
//     {
//         return $this->manager
//                     ->db
//                     ->exec('DELETE FROM utilisateur WHERE id = '.$perso->getId());
//     }

//     public function exists($info)
//     {
//         if(is_integer($info)) // On veut voir si tel personnage ayant pour id $info existe.
//         {
//         return (bool) $this->manager
//                             ->db
//                             ->query('SELECT COUNT(*) FROM utilisateur WHERE id = '.$info)->fetchColumn();
//         }
//         // Sinon, c'est qu'on veut vérifier que le nom existe ou pas.
//         $q = $this->manager
//                     ->db
//                     ->prepare('SELECT COUNT(*) FROM personnages WHERE nom = :nom');
//         $q->execute([':nom' => $info]);
//         return (bool) $q->fetchColumn();
//     }

//     public function get($info)
//     {

//     if (is_int($info))
//     {
//         /* $q = $this->_db->query('SELECT id, nom, degats FROM personnages WHERE id = '.$info);*/
//         $q = $this->manager
//                     ->db
//                     ->prepare('SELECT id, nom, degats, experience, niveau FROM personnages WHERE id = :id' );
//         $q->execute([':id' => $info]);
//         $donnees = $q->fetch(PDO::FETCH_ASSOC);
                
//         return new Utilisateur($donnees);
//     } else {
//             $q = $this->manager
//                         ->db
//                         ->prepare('SELECT id, nom, degats FROM personnages WHERE nom = :nom');
//             $q->execute([':nom' => $info]);
            
//             return new Utilisateur($q->fetch(PDO::FETCH_ASSOC));
//             }
//     }

//     public function getPersoDying()
//     {
//         $persoDying = [];
//         $q = $this->manager
//                 ->db
//                 ->prepare( 'SELECT * FROM personnages WHERE degats >= 90' );
//         $q->execute();
//         $listRes = $q->fetchAll();

//         foreach( $listRes as $res ) {
//             $persoDying[] = new Utilisateur($res);
//         }
//         return $persoDying;
//     }

//     public function getAllListPerso()
//     {
//       $perso = [];
//       $q = $this->manager
//                 ->db
//                 ->prepare( 'SELECT * FROM personnages' );
//       $q->execute();
//       $listRes = $q->fetchAll();
//       foreach( $listRes as $res ) {
//           $perso[] = new Utilisateur($res);
//       }
//       return $perso;
//     }

//     public function getListToHit($nom)
//     {
//         $persos = [];

//         $q = $this->manager
//                     ->db
//                     ->prepare('SELECT id, nom, degats, experience, niveau FROM personnages WHERE nom <> :nom ORDER BY nom');
//         $q->execute([':nom' => $nom]);

//         while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
//         {
//             $persos[] = new Utilisateur($donnees);
//         }
//         return $persos;
//     }   

//     public function updateName(Utilisateur $perso)
//     {
//         $q = $this->manager
//             ->db
//             ->prepare('UPDATE personnages SET 
//                         nom = :nom
//                         WHERE id = :id');

//         $ret = $q->execute( [
//             ':nom'  => $perso->getNom(),
//             ':id'   => $perso->getId()
//         ]);
//         return $ret;
//     }


//   public function update(Utilisateur $perso)
//   {
//     $q = $this->manager
//                 ->db
//                 ->prepare('UPDATE personnages SET 
//                        degats = :degats,
//                        experience = :experience,
//                        niveau = :niveau
//                        WHERE id = :id');
//     $q->bindValue(':degats', $perso->getDegats(), PDO::PARAM_INT);
//     $q->bindValue(':id', $perso->getId(), PDO::PARAM_INT);
//     $q->bindValue(':experience', $perso->getExperience(), PDO::PARAM_INT);
//     $q->bindValue(':niveau', $perso->getNiveau(), PDO::PARAM_INT);
//     $ret = $q->execute();
//     return $ret;
//   }


}