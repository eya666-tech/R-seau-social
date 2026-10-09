<?php  
session_start();
require_once("../modele/Utilisateur.php");
require_once("../modele/Amis.php");
require_once("../modele/Notification.php");

if(!isset($_SESSION['id'] ))
{
    header("Location: ../vue/connexion.html"); 
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
body {   
   font-family: "Segoe UI", sans-serif;  
  background: linear-gradient(135deg, #eef2f7, #dfe9f3);
}
  
  .navbar {    background: linear-gradient(135deg, #4f46e5, #6366f1);   
     padding: 12px 0;   
      box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }
  .navbar-brand {    font-weight: bold;   
     font-size: 20px;
    }
  .nav-link {    color: white !important;  
  transition: 0.3s;}

  .nav-link:hover {    color: #ffd700 !important;}
  .card {    border: none; 
     border-radius: 18px; 
      box-shadow: 0 10px 25px rgba(0,0,0,0.08);   
      transition: 0.3s;}
       .card:hover {    transform: translateY(-5px);}
   .profile-img {    width: 90px;    height: 90px; 
 border-radius: 50%;    object-fit: cover;  
   border: 4px solid #4f46e5;}
     .btn-main {    background: linear-gradient(135deg, #4f46e5, #6366f1);   
        color: white;}
  .btn-primary, .btn-success, .btn-danger {    border-radius: 10px;}

  .table-users {    margin-top: 20px;    border-radius: 12px;    overflow: hidden;}

  .table-users thead {    background: linear-gradient(135deg, #4f46e5, #6366f1);    color: white;}

  .table-users th, .table-users td {    text-align: center;    padding: 12px;}

  .table-users tbody tr:hover {    background: #f5f7ff;}
  
  .title h1 {    background: #eef2ff;    color: #4f46e5;    padding: 10px;    border-left: 5px solid #4f46e5;    border-radius: 8px;}
  .badge-notif {    background: red;    color: white;    border-radius: 50%;    font-size: 11px;    padding: 4px 7px;}
</style>
</head>


<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">MySocial</a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item"><a class="nav-link" href="../vue/acceuil.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="../vue/profil.php">Profil</a></li>
                <li class="nav-item"><a class="nav-link" href="../vue/amisinterfce.php">Amis</a></li>
                <li class="nav-item"><a class="nav-link" href="../vue/demande.php">Demandes</a></li>
                <li class="nav-item">
                <a class="nav-link" href="../vue/notiflicationsinterface.php"> Notifications 🔔 <span class="badge-notif"><?=Notification::nbrenonlue($_SESSION['id'])?></span> </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../vue/connexion.html">Déconnexion</a>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- CONTENU -->
<div class="container mt-4">

    <div class="row">

        
        <!-- PROFIL -->
        <div class="col-md-4">

            <div class="card p-3 text-center">
            <img src="../uploads/<?= $_SESSION['image']?>" class="profile-img mx-auto"> 
                <h5 class="mt-2"><?=$_SESSION['nom']?></h5>
                <!-- partie nbre d'amis -->
                <?php $amis=Amis::nbreAmis($_SESSION['id'])?>
                <p><?php echo$amis?>amis</p>
                <a href="../vue/profil.php" class="btn btn-primary btn-sm">Voir Profil</a>
            </div>

            <!-- CREER COMPTE -->
            <div class="card p-3 mt-3 text-center">
                <a href="../vue/utlisateurforme.php" class="btn btn-success">Créer un compte</a>
            </div>

        </div>

        <!-- RECHERCHE -->
       <?php
        $utilisateurs = [];
        if(isset($_POST["rechercher"]))
        {
        $recherche=$_POST['nommail'];
        if(!empty($_POST['nommail']))
        {
            $utilisateurs=Utilisateur::Chercherutlisateur($recherche,$_SESSION['id']);
         }}
        ?>

        <div class="col-md-8">
            <div class="card p-3">
                <h5>🔍 Rechercher des utilisateurs</h5>

                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                    <input type="text" class="form-control mb-2" placeholder="Entrer un nom..." name="nommail">
                    <button class="btn btn-main" name="rechercher">Rechercher</button>
                </form>

                 <?php
        if (isset($_POST["rechercher"])) {
            if (!empty($utilisateurs)) {
        ?>

        <div class="title"><h1>Voici la liste des utilisateurs:</h1></div>
        <table class="table table-users table-bordered">
    <thead>
        <tr>
            
            <th>nom</th>
            <th>email</th>
            <th>image</th>
            <th>Action</th>
        </tr>
    </thead>

   
    <tbody>
        <?php foreach ($utilisateurs as $user) { ?>
        <tr>

                <td><?= $user->nom ?></td>
                <td><?= $user->email ?></td>
                <td><img src="../uploads/<?= $user->image ?>" width="50" alt="image"></td>
                <td>

                    <form method="post" action="../controleur/controlleurdemandeamis.php" style="display:inline;">
                        <!-- recepteur-id -->
                        <input type="hidden" name="user_id" value="<?= $user->id ?>">
                        <button class="btn btn-success btn-sm" name="envoyer"> Envoyer</button>
                        <button class="btn btn-danger btn-sm" name="annuler">Annuler</button>
                    </form>
             </td>
           </tr>
        <?php } ?>
    </tbody>
    </table>
    
    <?php } else { ?>
<p class="text-danger">Aucun utilisateur trouvé</p>
<?php } } ?>
        </div>

    </div>
    </div>
</div> 

</body>
</html>