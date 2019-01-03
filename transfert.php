<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title> we transfert</title>
</head>
<body>
    

<?php
/*
Plugin Name: We Transfert
Plugin URI: http://localhost/
Description: Pour le partage de fichiers à la 'We Transfert'.
Author: D Codeurs du Lac - SylvieG
Version: 1.0.0
Author URI: http://localhost/
*/
?>


 <!-- formulaire -->

    <form action="trt.php" method="post" enctype="multipart/form-data">  
    <!-- propriété  enctype car envoie de données binaires (fichier) -->
        <div class="fich">
            <input type="hidden" name="MAX_FILE_SIZE" value="1048576">
            <!-- restriction en octet (1MO = 1024Ko = 1024x1024 octets) de la taille du fichier a mettre en hidden avant selection fichier -->
            <label for="fichier">votre fichier :</label>
            <input type="file" name="fichier" id="nomFichier" required>
        </div>
        <div class="mail">
            <label for="mail1">Votre e-mail (expéditeur) :</label>
            <input type="email" name="emailExp" id="expMail" required>
        </div>
        <div class="mail">
            <label for="mail2">e-mail du destinataire :</label>
            <input type="email" name="emailDest" id="destMail" required>
        </div>

        <input type="submit" value="Envoyer">

    </form>


</body>
</html>
