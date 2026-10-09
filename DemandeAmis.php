<?php
require_once("../modele/connx.php");
class DemandeAmis
{
    private $id;
    private $demandeur_id;
    private $recepteur_id;
    private $statut;
    private $dateCreation;

     //constructeur
     public function __construct($id,$demandeur_id,$recepteur_id,$statut,$dateCreation) 
     {
         $this->id = null;
         $this->demandeur_id = $demandeur_id;
         $this->recepteur_id =$recepteur_id;
         $this->statut = $statut;
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
        <td>{$this->demandeur_id}</td>
        <td>{$this->recepteur_id}</td>
        <td>{$this->statut}</td>
        <td>{$this->dateCreation}</td>
    </tr>";

    return $ligne;
}

public static function GetDemandeEnvoyee($demandeur_id)
{
global $bdd;
$tabenvoye = [];
$stmt = $bdd->prepare("SELECT d.statut, u.nom, u.image, u.email
    FROM demande_amis d
    JOIN utilisateurs u ON u.id = d.recepteur_id 
    WHERE d.demandeur_id = :id
");
$stmt->bindParam(":id", $demandeur_id);
$stmt->execute();

$stmt->bindColumn(1, $statut);
$stmt->bindColumn(2, $nom);
$stmt->bindColumn(3, $image);
$stmt->bindColumn(4, $email);

while($stmt->fetch(PDO::FETCH_BOUND))
{
     $tabenvoye[]= ["nom" => $nom,"email" => $email,"image" => $image,"statut" => $statut ];
}
$stmt->closeCursor();
return $tabenvoye;
}

public static function GetDemandeRecu($recepteur_id)
{  global $bdd;
    $tabrecu = [];
    $stmt = $bdd->prepare("
    SELECT d.statut, d.demandeur_id, u.nom,u.image, u.email,d.id
    FROM demande_amis d
    JOIN utilisateurs u ON u.id = d.demandeur_id
    WHERE d.recepteur_id = :id
");

$stmt->bindParam(":id", $recepteur_id);
$stmt->execute();

$stmt->bindColumn(1, $statut);
$stmt->bindColumn(2, $demandeur_id);
$stmt->bindColumn(3, $nom);
$stmt->bindColumn(4, $image);
$stmt->bindColumn(5, $email);
$stmt->bindColumn(6, $id);

while($stmt->fetch(PDO::FETCH_BOUND))
{
    $tabrecu[]= ["statut" => $statut, "demandeur_id" => $demandeur_id,"nom" => $nom,"image" => $image,"email" => $email,"id" =>$id];
}
$stmt->closeCursor();
return $tabrecu;

}

public static function envoyerdemande($demandeur_id ,$recepteur_id)
{
    global $bdd;
 $req=$bdd->prepare("insert into  demande_amis (demandeur_id, recepteur_id, statut, dateCreation)values(:demandeur,:recepteur,'EN_ATTENTE', NOW())");
 $req->bindParam(":demandeur",$demandeur_id);
 $req->bindParam(":recepteur",$recepteur_id);
$req->execute();
return $bdd->lastInsertId();

}


public static function Annulerdemande($demandeur_id ,$recepteur_id)
{
    global $bdd;
    $sql=$bdd->prepare("DELETE FROM demande_amis WHERE (

 (demandeur_id = :demandeur AND recepteur_id = :recepteur)
 OR
 (demandeur_id = :recepteur AND recepteur_id = :demandeur)
)");
    $sql->bindParam(":demandeur",$demandeur_id);
    $sql->bindParam(":recepteur",$recepteur_id);
    $sql->execute();
 if ($sql->rowCount() > 0)
 {
    return true;
 }
 return false;
}


public static function Accepteedemande($demandeur_id ,$recepteur_id)
{
    global $bdd;

    // 1. update statut
    $sql = $bdd->prepare(" UPDATE demande_amis SET statut = 'ACCEPTEE'  
     WHERE (demandeur_id = :demandeur AND recepteur_id = :recepteur) 
    OR (demandeur_id = :recepteur AND recepteur_id = :demandeur)");

    $sql->bindParam(":demandeur", $demandeur_id);
    $sql->bindParam(":recepteur", $recepteur_id);
    $sql->execute();

    if ($sql->rowCount() == 0) {
        return false;
    }

    // 2. symetrique qui retouner le min et le max pour crée un seule relation
    $user1 = min($demandeur_id, $recepteur_id);
    $user2 = max($demandeur_id, $recepteur_id);

    // 3. vérifier si déjà amis
    $sql2 = $bdd->prepare("SELECT * FROM amis WHERE utilisateur1_id = :u1 AND utilisateur2_id = :u2");
    $sql2->bindParam(":u1", $user1);
    $sql2->bindParam(":u2", $user2);
    $sql2->execute();

    if ($sql2->rowCount() > 0) {
        return true; // déjà amis
    }

    // 4. insertion
    $req = $bdd->prepare(" INSERT INTO amis (utilisateur1_id, utilisateur2_id, dateCreation) 
        VALUES (:user1, :user2, NOW())");

    $req->bindParam(":user1", $user1);
    $req->bindParam(":user2", $user2);
    $req->execute();

    return true;
}

public static function Rejeteedemande($demandeur_id ,$recepteur_id)
{
    global $bdd;

    $sql = $bdd->prepare(" UPDATE demande_amis SET statut = 'REJETEE' 
        WHERE (demandeur_id = :demandeur AND recepteur_id = :recepteur)
        OR (demandeur_id = :recepteur AND recepteur_id = :demandeur)
    ");

    $sql->bindParam(":demandeur", $demandeur_id);
    $sql->bindParam(":recepteur", $recepteur_id);

    $sql->execute();

    if ($sql->rowCount() > 0)
    {
        return true;
    }
    return false;
}
public static function verifierDemande($id1, $id2)
{
    global $bdd;

    $req = $bdd->prepare("
        SELECT statut FROM demande_amis
        WHERE (demandeur_id = :id1 AND recepteur_id = :id2)
        OR (demandeur_id = :id2 AND recepteur_id = :id1)
    ");
    $req->bindParam(":id1",$id1);
    $req->bindParam(":id2",$id2);
    $req->execute();
    return $req->fetch(PDO::FETCH_ASSOC);
}

}
?>