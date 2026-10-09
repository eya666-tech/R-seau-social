<?php
session_start();
require_once("../modele/Utilisateur.php");

if (isset($_POST["connexion"])) {

    if (!empty($_POST['email'])) 
        {
        $email = $_POST['email'];
        $password = $_POST['motDePasse'];

        $user = Utilisateur::connection($email);

        if ($user)
        {

            if (password_verify($password, $user['motDePasse'])) {

                $_SESSION['id'] = $user['id'];
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['image'] = $user['image'];

                header("Location:../vue/acceuil.php");
                exit;
            } else {
                echo "Mot de passe incorrect ";
            }

        } else {
            echo "Email introuvable ";
        }

    } else {
        echo "Remplir tous les champs ";
    }
}

if(isset($_POST["Déconnexion"]))
{
  session_unset();
  session_destroy();
  header("location:../vue/utlisateurforme.php");
  exit;
}
?>