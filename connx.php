<?php
try
{
    $bdd=new PDO('mysql:host=localhost;dbname=reseau_social','root','');
    //var_dump($bdd);
}
catch(PDOEXCEPTION $e)
{
die('Erreur:'.$e->getMessage());
}
    
?>