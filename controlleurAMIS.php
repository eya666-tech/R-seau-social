<?php
session_start();
require_once("../modele/Amis.php");
if(isset($_POST['supprimer']))
{
    $id=$_SESSION['id'];
    $idamis=$_POST['idamis'];
    
    if(Amis::SupprimerAmis($id,$idamis))
    header("location:../vue/amisinterfce.php");
    exit;
}
    else
    {
        echo"Probléme au niveau du suppression";
    }

?>