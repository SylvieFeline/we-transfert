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

    <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post" enctype="multipart/form-data">  
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

    <?php

// ----------controle sur le fichier -----------

// vérification fichier bien upload (error = 0 ou UPLOAD_ERR_OK)
if ($_FILES['fichier']['error']) {     
    switch ($_FILES['fichier']['error']){     
             case 1: // UPLOAD_ERR_INI_SIZE     
             echo"Le fichier dépasse la limite autorisée par le serveur (fichier php.ini) !";     
             break;     
             case 2: // UPLOAD_ERR_FORM_SIZE     
             echo "Le fichier dépasse la limite autorisée dans le formulaire HTML !"; 
             break;     
             case 3: // UPLOAD_ERR_PARTIAL     
             echo "L'envoi du fichier a été interrompu pendant le transfert !";     
             break;     
             case 4: // UPLOAD_ERR_NO_FILE     
             echo "Le fichier que vous avez envoyé a une taille nulle !"; 
             break;     
    }  
}     
if ((isset($_FILES['fichier']['tmp_name'])&&($_FILES['fichier']['error'] == UPLOAD_ERR_OK))) {     

    // vérification de l'extension  (pour une image)
        $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
        $extensionFichier = strtolower(  substr(  strrchr($_FILES['fichier']['name'], '.')  ,1)  );
        if ( in_array($extensionFichier,$extensions_valides) ) { 
            echo "Extension correcte";

        // renommer le fichier pour ne pas avoir de doublon 
        // en utilisant la date et l'heure
            $repertoireDestination = dirname(__FILE__)."/fichiers/";
            $nomDestination = "fichier_du_".date("YmdHis").".".$extensionFichier;

        // --> déplacement du fichier  du répertoire temporaire vers un répertoire de destination:
            move_uploaded_file($_FILES['fichier']['tmp_name'], $repertoireDestination.$nomDestination);
        
        // message de confirmation fichier uploader et mail envoyé
            echo "Votre fichier <strong>". $_FILES['fichier']['name']. "</strong> est maintenant disponible à l'adresse de partage suivante :<br>";
            echo "http://localhost/sites/weTransfert/fichiers/".$nomDestination."<br>";
            echo "Un mail a été envoyé à ".$_POST['emailExp']. " pour l'informer de ce partage. <br>";
            echo "Les D codeurs du lac vous remercie d'avoir utiliser leur systeme de partage de fichier. <br>";
    
        //  mail informant de la mise à disposition du fichier par l'expéditeur 
        //  avec lien pour son téléchargement

            $to = $_POST['emailDest'];
                    $object = 'fichier partagé';
                    $message = $_POST['emailExp'].' vous a envoyé ce fichier : <br>';
                    $message.= $_FILES['fichier']['name'];
                    $message.='<br> Vous pouvez le télécharger grâce au lien ci-dessous : <br>';
                    $message.= "<a href='http://localhost/sites/weTransfert/fichiers/".$nomDestination."'> lien vers le fichier partagé </a>";

                    $headers = 'From:'. " ".$_POST['emailExp']."\r\n";
                    $headers .= 'MIME-Version: 1.0' ."\r\n";
                    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
                    mail($to, $object, $message, $headers);


        }  else {
            echo "Extension non valide, votre fichier n'est pas mis en partage";
        }
}  



?>  


</body>
</html>
