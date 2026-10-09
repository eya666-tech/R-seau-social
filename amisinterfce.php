<?php
session_start();
require_once("../modele/Amis.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Amis</title>

    <style>
    body {
    font-family: "Segoe UI", Tahoma, sans-serif;
    background: linear-gradient(135deg,#eef2f7,#dfe9f3);
    margin: 0;
    padding: 0;
}
.container {
    width: 85%;
    max-width: 1100px;
    margin: 40px auto;
}
h2 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 25px;
    font-size: 28px;
}
.search-box {
    display: flex;
    gap: 10px;
    margin-bottom: 25px;
}
.search-box input {
    flex: 1;
    padding: 12px;
    border: none;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    outline: none;
}
.search-box button {
    padding: 12px 18px;
    background: linear-gradient(135deg,#4f46e5,#6366f1);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s;
}
.search-box button:hover {
    transform: scale(1.05);
}
table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    animation: fadeIn 0.5s ease-in-out;
}
thead {
    background: linear-gradient(135deg,#4f46e5,#6366f1);
    color: white;
}
th {
    padding: 14px;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 1px;
}
td {
    padding: 14px;
    text-align: center;
    color: #333;
    border-bottom: 1px solid #f1f1f1;
}
tbody tr {
    transition: 0.2s;
}

tbody tr:hover {
    background: #f5f7ff;
    transform: scale(1.01);
}
tbody tr:nth-child(even) {
    background-color: #fafafa;
}
td img {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #4f46e5;
}
h3 {
    text-align: center;
    margin: 20px 0;
    color: #4f46e5;
    font-size: 22px;
}
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
    </style>
</head>

<body>

<div class="container">

    <h2>👥Gestion des amitiés</h2>

    <!-- 🔍 Recherche -->
     <?php
     if(isset($_POST['rechercher']))
     {
        $recherche=$_POST['nomemail'];

    if(!empty($recherche))
    {
        $tabdAMIS=Amis::ChercherAmis($recherche,$_SESSION['id']);
    }
    }
     else
     {
        $tabdAMIS = Amis::getAmis($_SESSION['id']);
     }
     ?>

     <!-- formulire de Recherche -->
    <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" class="search-box">
        <input type="text" name="nomemail" placeholder="Rechercher un ami...">
        <button type="submit" name="rechercher">Rechercher</button>
    </form>

    <div>
<h3> Liste des amis:</h3>
    <table>
<thead>
        <tr>
            <th>nom</th>
            <th>email</th>
            <th>image</th>
            <th>nombre d'ami en commun</th>
            <th>action</th>
        </tr>
    </thead>
<tbody>

<?php
foreach($tabdAMIS as $amis) {
?>
<tr>
    
    <td><?= $amis['nom'] ?></td>
    <td><?= $amis['email'] ?></td>
    <td><img src="../uploads/<?= $amis['image'] ?>" class="profile-img"></td>

    <?php $nbamis=Amis::nbreAmiscommun($_SESSION['id'],$amis['id']);?>
    <td><?= $nbamis?>amis</td>

    <!-- la formulaire de suppression -->
    <td>
    <form action="../controleur/controlleurAMIS.php" method="post" >
    <input type="hidden" name="idamis" value="<?= $amis['id'] ?>">
    <button type="sumbit" name="supprimer" class="btn btn-danger" onclick="return confirm('Voulez-vous supprimer votre compte ?')">🗑️ Supprimer</button>
    </form>
     </td>
</tr>
<?php
}
?>
</tbody>
</table>
</body>
</html>