<?php
require_once("../modele/connx.php");
class Utilisateur
{
    private $id;
    private $nom;
    private $email;
    private $motdepasse;
    private $image;
    private $dateCreation;
    
    public function __construct($nom, $email, $motdepasse, $image, $dateCreation,$id=null)
{
    $this->id = $id;
    $this->nom = $nom;
    $this->email = $email;
    $this->motdepasse = $motdepasse;
    $this->image = $image;
    $this->dateCreation = $dateCreation;
}

    function __get($att){
        if(!isset($this->$att))return "erreur. Attribut non défini pour l'objet! <br>";
        return $this->$att;
    }
    function __set($att,$val){
        $this->$att=$val;
    }
    public function __toString(){
        $ligne = "<tr>
            <td>{$this->id}</td>
            <td>{$this->nom}</td>
            <td>{$this->email}</td>
            <td>{$this->motdepasse}</td>
            <td>{$this->image}</td>
            <td>{$this->dateCreation}</td>
        </tr>";
    
        return $ligne;
    }
public static function GetUtilisateur()
{
    global $bdd;

    $tabUser = [];
        $stmt = $bdd->prepare("SELECT nom, email, motDepasse, image, dateCreation FROM utilisateurs");
        $stmt->execute();

       
        $stmt->bindColumn(1, $nom);
        $stmt->bindColumn(2, $email);
        $stmt->bindColumn(3, $motdepasse);
        $stmt->bindColumn(4, $image);
        $stmt->bindColumn(5, $dateCreation);

        while ($stmt->fetch(PDO::FETCH_BOUND)) {
            $tabUser[] = new Utilisateur($nom, $email, $motdepasse, $image, $dateCreation);
        }

        $stmt->closeCursor();
        return $tabUser;
}
public function InscriptionUtilisateurs()
{
    global $bdd;

    try {
        $stmt = $bdd->prepare("INSERT INTO utilisateurs (nom, email, motDepasse, image, dateCreation)
        VALUES (:nom, :email, :motdepasse, :image, NOW())");

        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':motdepasse', $this->motdepasse);
        $stmt->bindParam(':image', $this->image);
        $stmt->execute();
        

        $id = $bdd->lastInsertId();
        return  $id;

    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}


    public static  function SupprimerUtlisateur($id)
    {  global $bdd;

        try
        {
            $stmt = $bdd->prepare("DELETE FROM utilisateurs WHERE id = :id");
            $stmt->bindParam(":id",$id);
            $stmt->execute();
    
            if($stmt->rowCount() > 0)
                return true;
            else
                return false;
        }
        catch(PDOException $e)
        {
            return false;
        }
    }

  
public function ModifierUtilisateur($id)
{
    global $bdd;
    try
    {
    $stmt = $bdd->prepare("UPDATE utilisateurs SET nom = :nom,email = :email,motDepasse = :motdepasse,image = :img,dateCreation = :date WHERE id = :id");


    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nom', $this->nom);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':motdepasse', $this->motdepasse);
    $stmt->bindParam(':img', $this->image);
    $stmt->bindParam(':date', $this->dateCreation);
   $stmt->execute();
   return true;
    }
     catch(PDOException $e) 
        {return false;
        }
}



   public static function connection($email)
{
    global $bdd;
    $sql = $bdd->prepare("SELECT * FROM utilisateurs WHERE email=:email");
    $sql->bindParam(":email",$email);
    $sql->execute();
    return $sql->fetch(PDO::FETCH_ASSOC);
  }


  public static function Chercherutlisateur($nomormail,$id)
  {
      global $bdd;
      $tabUser=[];
      $req=$bdd->prepare("SELECT id, nom, email, image  FROM utilisateurs where id!=:id and( email LIKE :email OR nom LikE :nom )");
      $nomormailrecherche="%$nomormail%";
      
      $req->bindParam(":id", $id);
      $req->bindParam(":email", $nomormailrecherche);
      $req->bindParam(":nom", $nomormailrecherche);

      $req->execute();
      $req->bindColumn(1, $id);
      $req->bindColumn(2, $nom);
      $req->bindColumn(3, $email);
      $req->bindColumn(4, $image);

      while ($req->fetch(PDO::FETCH_BOUND)) {
        $tabUser[] = new Utilisateur($nom, $email,"" ,$image,"",$id);
    }
    $req->closeCursor();
    return $tabUser;



  }
  

}
?>