<?php  session_start();
require_once("../modele/Utilisateur.php");

// if (!isset($_GET['edit'])) {
// session_unset();
//  //ha4i les sessions tfra8ha bech doub matod5ol til9a les champ vide
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion utilisateurs</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
   body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        background: #f0f2f5;
    }

    .title h1 {
        text-align: center;
        margin: 30px 0;
        color: #111;
        font-size: 28px;
    }

    form {
        width: 350px;
        margin: auto;
        padding: 20px;
        border: 1px solid #eee;
        border-radius: 10px;
       background-color: #ffffff;
       border: 1px solid #ddd;
}

    table {
        width: 100%;
    }

    td {
        padding: 8px 0;
    }

    label {
        font-size: 14px;
        color: #444;
    }

    input.form-control {
        border: none;
        border-bottom: 1px solid #ccc;
        border-radius: 0;
        box-shadow: none;
    }

    input.form-control:focus {
        border-bottom: 1px solid #000;
    }

    button {
        width: 100%;
        padding: 10px;
        border-radius: 6px !important;
        border: none;
        background-color: black;
        color: white;
        margin-top: 15px;
    }

    button:hover {
        background-color: #333;
    }
    .table-users {
    width: 85%;
    margin: 40px auto;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.table-users thead {
    background: linear-gradient(45deg, #28a745, #20c997);
    color: white;
}

.table-users th {
    padding: 12px;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 14px;
}

.table-users td {
    padding: 12px;
    vertical-align: middle;
}

.table-users tbody tr {
    transition: 0.2s;
}

.table-users tbody tr:hover {
    background-color: #f1fdf5;
    transform: scale(1.01);
}

.table-users img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
}
    .title h1 {
        color: #28a745;
        .table-users {
    width: 85%;
    margin: 40px auto;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}
}
</style>
    
<body>

<div class="title"><h1>Gestion des utilisateurs:</h1></div>

<!-- formulaire d'inscription -->
<form action="../controleur/utlistaeurcontrolleur.php" method="post" enctype="multipart/form-data">

<table>
<tr>
    <td><label>Nom:</label></td>
    <td><input type="text" name="nom" value="<?=$_SESSION['nom'] ?? "" ?>" class="form-control"></td>
    
</tr>

<tr>
    <td><label>Email :</label></td>
    <td><input type="email" name="email"  value="<?=$_SESSION['email'] ?? "" ?>" class="form-control"></td>
</tr>

<tr>
    <td><label>Mot de passe :</label></td>
    <td><input type="password" name="motDePasse" value="" class="form-control"></td>
</tr>

<tr>
    <td><label>Image :</label></td>
    <td><input type="file" name="image" value="<?= $_SESSION['image'] ?? ""?>" class="form-control"></td>
</tr>
</table>

<!-- les deux buttons s'inscrie et modifier -->
<?php if (!isset($_GET['edit'])){?>
<button type="submit" name="inscrire" class="btn btn-success">S'inscrire</button>
<?php }?>

 <?php if (isset($_GET['edit'])){?>
 <button type="submit" name="modifier" class="btn btn-warning">Modifier</button> 
 <?php }?>

</form>


</body>
</html>