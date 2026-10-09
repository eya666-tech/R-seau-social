<?php
session_start();
require_once("../modele/Notification.php");

if (isset($_POST['lue'])) {

if (isset($_POST['lu'])) {

    $idnotif = $_POST['lu'];

    Notification::marquerlueonnonlue($idnotif);

    header("Location: ../vue/notiflicationsinterface.php");
    exit;
    
  
}
}
if (isset($_GET['mark_all']) && $_GET['mark_all'] == "ok") {
    Notification::marquertouslue($_SESSION['id']);
    header("Location: ../vue/notiflicationsinterface.php");
    exit;
}

?>
