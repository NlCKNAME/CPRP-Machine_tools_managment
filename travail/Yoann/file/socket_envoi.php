<?php
//Création d'un socket TCP
if(!($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)))
{
    $erreur = socket_last_error();	//Retourne la dernière erreur générée par le socket
    $msgerreur = socket_strerror($erreur);	//Retourne le message d'erreur correspondant à l'erreur rencontrée
     
    exit("Impossible de créer le socket: [$erreur] $msgerreur \n");	//Termine le script courant et affiche un message
}

 
 
 //Connexion au socket
if(!socket_connect($socket, '172.19.175.174', 1470))
{
    $erreur = socket_last_error();
    $msgerreur = socket_strerror($erreur);
     
    exit("Impossible de se connecter: [$erreur] $msgerreur \n");
}



//Ouvrir un fichier et le lire
$nomfichier = 'fichier_temp.txt';
$lecture = fopen($nomfichier,'r');	// 'r' pour ouvrir le fichier en lecture seule

if($lecture)
{
   $fichier = fread($lecture, filesize($nomfichier));
   $fichier = $fichier . chr(19) ;	// On ajoute xOFF à la fin de la transmission
}
fclose($lecture);


//Envoyer un message au serveur
if(!socket_send ($socket, $fichier, strlen($fichier), 0))
{
    $erreur = socket_last_error();	
    $msgerreur = socket_strerror($erreur);
     
    exit("Impossible d'envoyer les données: [$erreur] $msgerreur \n");
}
echo "Message envoyé avec succès";
socket_close($socket);

header("Refresh: 2; url=../transmab.php"); //Attend 2 secondes puis redirige vers transmab.php
?>
