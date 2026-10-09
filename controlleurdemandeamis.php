<?php
session_start();
require_once("../modele/DemandeAmis.php");
require_once("../modele/Notification.php");

if(isset($_POST['envoyer']))
{
    $id_demandeur= $_SESSION['id'];
    $id_recepteur=$_POST['user_id'];

    if($id_demandeur==$id_recepteur)
    {
        echo"Impossible d’envoyer une demande à soi-même ";
    }

    $demandestatut=DemandeAmis::verifierDemande($id_demandeur,$id_recepteur);
              
    if((!empty($demandestatut))&&$demandestatut['statut'] == 'ACCEPTEE')
    {
        echo"Impossible d’envoyer une demande si déjà amis";
    }
     elseif((!empty($demandestatut))&&$demandestatut['statut'] == 'EN_ATTENTE')
    {
        echo"Impossible d’envoyer plusieurs demandes identiques entre deux utilisateurs";
    }
    else 
    {
      $id_demandeamitée=DemandeAmis::envoyerdemande($id_demandeur,$id_recepteur);

      $type ="demandeAmitié";
      Notification::Ajouternotif($id_recepteur,$id_demandeamitée,$type);
      header("location:../vue/acceuil.php");
      exit;
     }
 }


if (isset($_POST['annuler']))
{
    $id_demandeur =$_SESSION['id'] ;
    $id_recepteur = $_POST['user_id'];

    if (DemandeAmis::Annulerdemande($id_demandeur, $id_recepteur))
    {
        header("location:../vue/acceuil.php");
        exit;
    }
    else
    {
        echo "erreur lors de l'annulation";
    }
}

if(isset($_POST['accepter']))
{
    $id_demandeur = $_POST['demandeur_id'];
    $id_recepteur = $_SESSION['id'];

    if(DemandeAmis::Accepteedemande($id_demandeur, $id_recepteur))
    {
        $type = "demandeAcceptée";
        $id_demandeamitée=$_POST['id_demandeamitée'];
        Notification::Ajouternotif($id_demandeur,$id_demandeamitée,$type);
       
        header("location:../vue/demande.php");
        exit;
    }
}
if(isset($_POST['refuser']))
{
    $id_demandeur = $_POST['demandeur_id'];
    $id_recepteur = $_SESSION['id'];

    if(DemandeAmis::Rejeteedemande($id_demandeur, $id_recepteur))
    {
        $type ="demandeRefusée";
        $id_demandeamitée=$_POST['id_demandeamitée'];
        Notification::Ajouternotif($id_demandeur,$id_demandeamitée,$type);

        header("location:../vue/demande.php");
        exit;
    }
}
?>