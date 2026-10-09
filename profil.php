<?php  session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../vue/connexion.html");
 }
 ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f0f2f5;
        }

        .profile-card {
            max-width: 600px;
            margin: auto;
            margin-top: 50px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            text-align: center;
        }

        .cover {
            height: 120px;
            background: #4e73df;
            border-radius: 10px 10px 0 0;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid white;
            margin-top: -60px;
            object-fit: cover;
            background: #ddd;
        }

        .info {
            margin-top: 15px;
        }

        .btns {
            margin-top: 20px;
        }
        .delete-form {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}
.delete-card {
    display: flex;
    justify-content: center;
    margin-top: 30px;
}
.btn-danger-soft {
    background: #fff;
    color: #e74c3c;
    border: 2px solid #e74c3c;
    padding: 12px 25px;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
}
.btn-danger-soft:hover {
    background: #e74c3c;
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(231, 76, 60, 0.3);
}
.btn-danger-soft:active {
    transform: scale(0.97);
}
.info {
    width: 300px;
    margin: 30px auto;
    padding: 20px;
    background: white;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    transition: 0.3s;
    font-family: "Segoe UI", sans-serif;
}
.info:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.info h3 {
    margin-bottom: 10px;
    font-size: 22px;
    color: #2c3e50;
}


.info p {
    margin: 6px 0;
    color: #555;
    font-size: 14px;
}

.info p:nth-child(2) {
    font-weight: bold;
    color: #4f46e5;
    font-size: 16px;
}

.info p:nth-child(3) {
    color: #1f2937;
}

.info p:nth-child(4) {
    font-size: 12px;
    color: #888;
}
    </style>
</head>

<body>

<?php require_once("../modele/Amis.php");?>
<div class="profile-card">

    <div class="cover"></div>

    <!-- PHOTO -->
    <img src="../uploads/<?= $_SESSION['image'] ?>" class="profile-img">

    <!-- INFOS  -->
    <div class="info">
        
        <h3><?=$_SESSION['nom']?></h3>
        <p><?=$_SESSION['email']?></p>

         <!-- partie nbre d'amis -->
        <!-- // <?php $amis=Amis::nbreAmis($_SESSION['id'])?> -->
         <p><?php echo$amis?>amis</p>

    </div>


    <div class="btns d-flex justify-content-center gap-3">
        <!-- href modifier -->
    <a href="../vue/utlisateurforme.php?edit=<?= $_SESSION['id'] ?>" class="btn btn-primary">✏ Modifier Profil</a>
    
     <!-- la formulaire de suppression -->
    <form action="../controleur/utlistaeurcontrolleur.php" method="post" >
    <input type="hidden" name="id" value=" <?= $_SESSION['id']?>">
    <button type="sumbit" name="supprimer" class="btn btn-danger" onclick="return confirm('Voulez-vous supprimer votre compte ?')"> Supprimer</button>
    </form>

    </div>

</div>

</body>
</html>