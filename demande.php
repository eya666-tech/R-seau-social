<?php
session_start();
 ?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Demandes d’amis</title>

<style>
body{
    font-family: 'Segoe UI', Tahoma, sans-serif;
    background: linear-gradient(135deg,#eef2f7,#dfe9f3);
    padding:30px;
}
.container{
    max-width:1100px;
    margin:auto;
}
h2{
    text-align:center;
    margin-bottom:30px;
    color:#2c3e50;
    font-size:28px;
}
.grid{
    display:flex;
    flex-direction:column;
    gap:30px;
}
table{
    width:100%;
    border-collapse:separate;
    border-spacing:0;
    background:white;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
    transition:0.3s;
}
table:hover{
    transform:translateY(-3px);
}
th{
    background: linear-gradient(135deg,#4f46e5,#6366f1);
    color:white;
    padding:15px;
    font-size:13px;
    text-transform:uppercase;
    letter-spacing:0.5px;
}
td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #f1f1f1;
    font-size:14px;
}
tr:hover td{
    background:#f5f7ff;
    transition:0.2s;
}
td img{
    width:40px;
    height:40px;
    border-radius:50%;
    object-fit:cover;
    border:2px solid #4f46e5;
}
.status{
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:bold;
}
.pending{
    background:#fff3cd;
    color:#856404;
}
.accepted{
    background:#d4edda;
    color:#155724;
}
.rejected{
    background:#f8d7da;
    color:#721c24;
}
.btn{
    padding:6px 10px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-size:12px;
    margin:2px;
    transition:0.2s;
}
.accept{
    background:#28a745;
    color:white;
}
.accept:hover{
    background:#1e7e34;
}
.reject{
    background:#dc3545;
    color:white;
}
.reject:hover{
    background:#b21f2d;
}
.cancel{
    background:#ffc107;
    color:#333;
}
.cancel:hover{
    background:#e0a800;
}
h3{
    margin-bottom:10px;
    color:#4f46e5;
    font-weight:bold;
}
</style>

</head>

<body>
<span style="color: #eef2f7;"><?php require_once("../modele/DemandeAmis.php");?></span>
<div class="container">

<h2>Gestion des demandes d’amis:</h2>

<div class="grid">

<!-- ENVOYÉES -->
<div>
<h3>Demandes envoyées:</h3>

<table>
<thead> 
<tr>
    <th>nom</th>
    <th>email</th>
    <th>image</th>
    <th>Status</th>
</tr>
</thead>

<tbody>

<?php
    $tabdemande=DemandeAmis::GetDemandeEnvoyee($_SESSION['id']);
    foreach( $tabdemande as $demande)
    {?>
    <tr>
    <td><?= $demande['nom']?></td>
    <td><?= $demande['email']?></td>
    <td><img src="../uploads/<?=  $demande['image'] ?>" class="profile-img"></td>
    <td><span class="status pending"><?=$demande['statut']?></span></td>
    </tr>
    <?php
     }?>

</tbody>
</table>
</div>

<!-- REÇUES -->
<div>
<h3> Demandes reçues:</h3>

<table>
<thead> 
<tr>
    
    <th>nom</th>
    <th>email</th>
    <th>image</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php
    $tabdemanderecu=DemandeAmis::GetDemandeRecu($_SESSION['id']);
    foreach( $tabdemanderecu as $demande)
    {
    ?>
    <tr>
    <td><?= $demande['nom']?></td>
    <td><?= $demande['email']?></td>
    <td><img src="../uploads/<?=  $demande['image'] ?>" class="profile-img"></td>
    <td><span class="status pending"><?=$demande['statut']?></span></td>
    <td>

    <form action="../controleur/controlleurdemandeamis.php" method="POST">
    <input type="hidden" name="demandeur_id" value="<?= $demande['demandeur_id']?>">
    <input type="hidden" name="id_demandeamitée" value="<?= $demande['id'] ?>">
    <button class="btn accept" name="accepter">Accepter</button>
    <button class="btn reject" name="refuser">Refuser</button>
    </form>

    </td>
    </tr>
    <?php }?>
</tbody>
</table>

</div>

</div>

</div>

</body>
</html>