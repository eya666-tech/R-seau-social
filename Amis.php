<?php
include("../modele/connx.php");

class Amis
{
    private $id;
    private $utilisateur1_id ;
    private $utilisateur2_id ;
    private $dateCreation;


     public function __construct($id,$utilisateur1_id,$utilisateur2_id,$dateCreation) 
     {
         $this->id = $id;
         $this->utilisateur1_id = $utilisateur1_id;
         $this->utilisateur2_id =$utilisateur2_id;
         $this->dateCreation = $dateCreation;
     }
     
    function __get($att)
    {
        if(!isset($this->$att))
        return "erreur. Attribut non défini pour l'objet! <br>";
        return $this->$att;
    }
    function __set($att,$val)
    {
        $this->$att=$val;
    }
   public function __toString(){
    $ligne = "<tr>
        <td>{$this->id}</td>
        <td>{$this->utilisateur1_id}</td>
        <td>{$this->utilisateur2_id}</td>
        <td>{$this->dateCreation}</td>
    </tr>";

    return $ligne;
}

// methode get amis

public static function GetAmis($id_user)
{
    global $bdd;
    $tab=[];

    $sql = $bdd->prepare("SELECT  u.id,u.nom, u.email, u.image FROM amis a
        join  utilisateurs u on  u.id= a.utilisateur1_id oR u.id=utilisateur2_id
       where  (utilisateur1_id = :id OR utilisateur2_id = :id )and (u.id!=:id)");

    $sql->bindValue(":id", $id_user);
    $sql->execute();
    
    $sql->bindColumn(1, $id);
    $sql->bindColumn(2, $nom);
    $sql->bindColumn(3, $email);
    $sql->bindColumn(4, $image);
    


     while ($sql->fetch(PDO::FETCH_BOUND)) {
        $tab[] = [
            "id" => $id,
            "nom" => $nom,
            "email" => $email,
            "image" => $image
        ];
    }
$sql->closeCursor();
 return $tab;
}


 public static function ChercherAmis($nomormail,$id)
 {
    global $bdd;
    $tab=[];
    $req=$bdd->prepare("SELECT u.id,u.nom, u.email, u.image FROM utilisateurs u
    join amis a on( u.id=a.utilisateur1_id and a.utilisateur2_id=:id) OR(u.id=a.utilisateur2_id and a.utilisateur1_id=:id)
    where u.id!=:id and (u.email LIKE :email OR u.nom LikE :nom) ");

    $nomormailrecherche="%$nomormail%";

    $req->bindParam(":id",$id);
    $req->bindParam(":email", $nomormailrecherche);
    $req->bindParam(":nom", $nomormailrecherche);

    $req->execute();

    $req->bindColumn(1, $id);
    $req->bindColumn(2, $nom);
    $req->bindColumn(3, $email);
    $req->bindColumn(4, $image);
    

    while ($req->fetch(PDO::FETCH_BOUND)) {
        $tab[] = [
            "id" => $id,
            "nom" => $nom,
            "email" => $email,
            "image" => $image
        ];
    }

 return $tab;
  }




public static function SupprimerAmis($id,$idamis)
{
    global $bdd;
    $sql=$bdd->prepare("DELETE FROM amis where( utilisateur1_id=:id and utilisateur2_id=:idamis )OR (utilisateur2_id=:id 
    and utilisateur1_id=:idamis)");

    $sql->bindParam(":id",$id);
    $sql->bindParam(":idamis",$idamis);

    $sql->execute();
    

    $sql1=$bdd->prepare("DELETE FROM demande_amis where( demandeur_id=:id and recepteur_id=:idamis)OR  (recepteur_id=:id 
    and demandeur_id=:idamis)");
      $sql1->bindParam(":id",$id);
      $sql1->bindParam(":idamis",$idamis);
      $sql1->execute();
     return true;
}




public static function nbreAmis($id)
{  
    global $bdd;
    $sql=$bdd->prepare("select count(*)  AS nb from amis where(utilisateur1_id=:id OR utilisateur2_id=:id )");
    $sql->bindParam(":id",$id);
    $sql->execute();
    $resultat=$sql->fetch(PDO::FETCH_OBJ);
    return $resultat->nb;
}



public static function nbreAmiscommun($user1,$user2)
{
    global $bdd;
    
    
    $sql = $bdd->prepare("
    SELECT COUNT(*) AS nbcommun
        FROM (
            SELECT utilisateur2_id AS ami
            FROM amis
            WHERE utilisateur1_id = :user1

            UNION

            SELECT utilisateur1_id AS ami
            FROM amis
            WHERE utilisateur2_id = :user1
        ) amis1

        INNER JOIN (
            SELECT utilisateur2_id AS ami
            FROM amis
            WHERE utilisateur1_id = :user2

            UNION

            SELECT utilisateur1_id AS ami
            FROM amis
            WHERE utilisateur2_id = :user2
        ) amis2

        ON amis1.ami = amis2.ami
    ");
     $sql->bindParam(':user1', $user1);
     $sql->bindParam(':user2', $user2); 
     $sql->execute();
     $resultat=$sql->fetch(PDO::FETCH_OBJ);
     return $resultat->nbcommun;
}
}
?>