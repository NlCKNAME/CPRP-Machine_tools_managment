
<?php

// Définition de quelques variables
$local_file = 'c:/temp/test.txt';
$server_file = 'test.txt';

// Mise en place d'une connexion basique
$conn_id = ftp_connect("172.19.174.177",21) or exit('Erreur : connexion au serveur FTP impossible');

if($conn_id)
{
	echo "Connexion établie ! ";
}


// Identification avec un nom d'utilisateur et un mot de passe
$login_result = ftp_login($conn_id, "web", "webprojet4");

if($login_result)
{
	echo "login reussi ! "; 
}




// Tentative de téléchargement du fichier $server_file et sauvegarde dans le fichier $local_file
if (ftp_get($conn_id, $local_file, $server_file, FTP_BINARY)) {
    echo "Le fichier $local_file a été écris avec succès\n";
} else {
    echo "Il y a un problème\n";
}

// Fermeture de la connexion
ftp_close($conn_id);

?>
