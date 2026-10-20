<?php
// point d'entrée du projet : redirige vers l'accueil ou la connexion
session_start();
if (isset($_SESSION['id'])) {
    header("Location: vue/acceuil.php");
} else {
    header("Location: vue/connexion.html");
}
exit;
?>
