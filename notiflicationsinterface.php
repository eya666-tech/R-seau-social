<?php 
session_start();
require_once("../modele/Notification.php");?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Notifications</title>

<style>
body {
    font-family: Arial;
    background: #f2f2f2;
}

.container {
    width: 60%;
    margin: auto;
    margin-top: 30px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.badge {
    background: red;
    color: white;
    padding: 3px 8px;
    border-radius: 50%;
    font-size: 12px;
}

.notification {
    background: white;
    padding: 15px;
    margin-top: 10px;
    border-radius: 8px;
    display: flex;
    justify-content: space-between;
    border-left: 5px solid transparent;
}

.notification.unread {
    border-left: 5px solid #007bff;
    background: #eef5ff;
}

.type {
    font-weight: bold;
    font-size: 14px;
}

.message {
    margin-top: 5px;
    color: #333;
}

.date {
    font-size: 12px;
    color: gray;
}

.actions a {
    text-decoration: none;
    font-size: 12px;
    color: #007bff;
}
h2 {
    text-align: center;
    font-weight: 700;
    font-size: 28px;
    color: #2c3e50;
    margin: 25px 0;
    position: relative;
}
h2::after {
    content: "";
    display: block;
    width: 120px;
    height: 4px;
    background: linear-gradient(135deg, #4e73df, #224abe);
    margin: 10px auto 0;
    border-radius: 10px;
}
h2:hover {
    color: #4e73df;
    transition: 0.3s;
}
.header a {
    text-decoration: none;
    background: #4e73df;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 13px;
    transition: 0.3s;
    margin-right: 10px;
}

.header a:hover {
    background: #224abe;
}

/* bouton "marquer comme lue" */
.notification form button {
    background: #28a745;
    color: white;
    border: none;
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 12px;
    cursor: pointer;
    transition: 0.3s;
}

.notification form button:hover {
    background: #1e7e34;
}

/* optionnel: aligner les actions */
.notification form {
    display: flex;
    align-items: center;
}
</style>

</head>

<body>
<div class="container">

    <!-- HEADER -->
    <div class="header">
        <h2>🔔 Système de notifications</h2>

        <div>
        <a href="../controleur/controlnotifaction.php?mark_all=ok">Marquer toutes comme lues</a>
        <span class="badge"><?= Notification::nbrenonlue($_SESSION['id'])?></span>
        </div>
    </div>

   <?php
$tabnotif=Notification::Getnotif($_SESSION['id']);
foreach($tabnotif as $notif)
{ 
?>
    <div class="notification unread">
        <div>
        <div class="type"><?=$notif->type?></div>
        <div class="statut"><?= $notif->is_read==1? 'Lue' :'Non lue' ?></div>
        <div class="date"><?= $notif->dateCreation ?></div>
        </div>
                <form action="../controleur/controlnotifaction.php" method="POST">
                    <input type="hidden" name="lu" value="<?= $notif->id ?>">
                    <button type="submit" name="lue">Marquer comme lue</button>
                </form>

</div>
<?php
}?>

</body>
</html>
