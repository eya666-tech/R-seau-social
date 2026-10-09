<?php
require_once("../modele/connx.php");
class Notification
{
    private $id;
    private $utilisateur_id ;
    private $typeENUM ;
    private $reference_id;
    private $is_read;
    private $dateCreation;

     //constructeur
     public function __construct($utilisateur_id,$type,$reference_id,$is_read,$dateCreation,$id=null) 
     {
         $this->id = $id;
         $this->utilisateur_id = $utilisateur_id;
         $this->type =$type;
         $this->reference_id =$reference_id;
         $this->is_read=$is_read;
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
        <td>{$this->utilisateur_id}</td>
        <td>{$this->type}</td>
        <td>{$this->reference_id}</td>
        <td>{$this->is_read}</td>
        <td>{$this->dateCreation}</td>
    </tr>";

    return $ligne;
}

public static function Ajouternotif($idutilisateur,$idrefercence,$type)
{
    global $bdd;

    try
    {
        $sql = $bdd->prepare("
            INSERT INTO notifications 
            (utilisateur_id, type, reference_id, is_read, dateCreation) 
            VALUES (:id_utilisateur, :type, :idref, 0, NOW())
        ");

        $sql->bindValue(":id_utilisateur", $idutilisateur);
        $sql->bindValue(":type", $type);
        $sql->bindValue(":idref", $idrefercence);

        $sql->execute();
        return true;
    }
    catch (Exception $e)
    {
        echo("Erreur notification: " . $e->getMessage());
        return false;
    }
}
public static function Getnotif($idutilisateur)
{
    $tabnotif = [];
    global $bdd;
    $stmt=$bdd->prepare("SELECT type, is_read, dateCreation, reference_id,id
        FROM notifications 
        WHERE utilisateur_id = :id 
        ORDER BY dateCreation DESC");
    $stmt->bindParam(":id",$idutilisateur);
    $stmt->execute();
   
    
    $stmt->bindColumn(1, $type);
    $stmt->bindColumn(2, $is_read);
    $stmt->bindColumn(3, $dateCreation);
    $stmt->bindColumn(4, $reference_id);
    $stmt->bindColumn(5, $id);
    
    while ($stmt->fetch(PDO::FETCH_BOUND)) {
        $tabnotif[] = new Notification($idutilisateur, $type, $reference_id,$is_read,$dateCreation,$id);
    }

    $stmt->closeCursor();
    return $tabnotif;
}
public static function marquerlueonnonlue($idnotif)
{
    global $bdd;

    $stmt = $bdd->prepare("UPDATE notifications SET is_read = 1 WHERE id = :id");

    $stmt->bindParam(":id", $idnotif);
    $stmt->execute();

    return $stmt->rowCount() > 0;
}
public static function marquertouslue($iduser)
{
    global $bdd;

    $stmt = $bdd->prepare("UPDATE notifications SET is_read = 1 WHERE utilisateur_id= :id");

    $stmt->bindParam(":id",$iduser);
    $stmt->execute();

    return $stmt->rowCount() > 0;
}

public static function nbrenonlue($iduser)
{
    global $bdd;
    $stmt=$bdd->prepare("select count(*) as nbnonlue FROM notifications   where utilisateur_id= :id and is_read = 0");
    $stmt->bindParam(":id",$iduser);
    $stmt->execute();
    $resultat=$stmt->fetch(PDO::FETCH_OBJ);
    return $resultat->nbnonlue;

    
}
}
?>