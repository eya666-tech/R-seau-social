<?php
session_start();
require_once("../modele/Utilisateur.php");

if ( isset($_POST["inscrire"]))
 {
    
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $motdepasse_input = $_POST['motDePasse'];
    $motdepasse = password_hash($motdepasse_input, PASSWORD_DEFAULT);
    
    $image = $_FILES['image']['name'] ?? '';
    $tmp = $_FILES['image']['tmp_name'] ?? '';
    
    if (!empty($nom) && !empty($email) && !empty($motdepasse_input)) {
        
        if (!empty($image))
         {
             move_uploaded_file($tmp, "../uploads/". $image);
         }
        
        $user = new Utilisateur($nom,$email,$motdepasse,$image,date("Y-m-d H:i:s"));
        $id = $user->InscriptionUtilisateurs();

         if ($id) {
            $_SESSION['id']=$id;
            $_SESSION['nom'] = $nom;
            $_SESSION['email'] = $email;
            $_SESSION['image'] = $image;
            header("Location:../vue/acceuil.php");
            exit;
        } 
        else 
        {
            echo "Erreur lors de l'inscription";
        }
    } else 
    {
        echo "Veuillez remplir tous les champs obligatoires";
    }
}

 elseif(isset($_POST["supprimer"]))
 {    
     $id = $_POST['id'];
    if(!empty($id))
   {
       if(Utilisateur::SupprimerUtlisateur($id))
       {    
           session_destroy();
          
        header("Location:../vue/utlisateurforme.php");
        exit;
       }
      else
      {
          echo "<p style='color:red'>Erreur de suppression</p>";
      }
  }
}

 elseif(isset($_POST["modifier"]))
 {
    $id = $_SESSION['id'];
    $nom = $_POST['nom'];
    $email = $_POST['email'] ;

   $motdepasse = password_hash($_POST['motDePasse'] , PASSWORD_DEFAULT);
   $image = $_FILES['image']['name'] ?? "";

   if(!empty($nom) && !empty($email) && !empty($motdepasse) && !empty($image))
  {
    $user = new Utilisateur($nom,$email,$motdepasse,$image,date("Y-m-d H:i:s"));

      if($user->ModifierUtilisateur($id))
      {
            $_SESSION['id'] = $id;
            $_SESSION['nom'] = $nom;
            $_SESSION['email'] = $email;
            $_SESSION['image'] = $image;

           header("Location:../vue/profil.php");
           exit;
       }
       else
       {
           echo "<p style='color:red'>Erreur de Modification</p>";
       }
   }
   else
   {
       echo "Remplir tous les champs";
   }
}

?>