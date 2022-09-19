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

//Réception des données
$buf = '';
while(($bytes = socket_recv($socket, $t_buf, 48, 0)) !=false)
{
			
		$t_buf=str_replace("\0","",$t_buf);
		$buf .= $t_buf;		//Concatenation des données reçues

	if ($bytes != 48)	//Fin de la boucle quand toutes les données ont été transmise
		break;
}
socket_close($socket);

//Créer un fichier sur le serveur avec les données reçues
$nomfichier = $_POST['nom'] . ".txt";
$fichier = fopen($nomfichier, 'w+'); //Créer le fichier et l'ouvre en lecture et écriture
fwrite($fichier, $buf); //Copie le contenu de $buf dans le fichier
fclose($fichier);

//Télécharge le fichier sur le PC
if (file_exists($nomfichier)) 
{
    header('Content-disposition: attachment; filename='.$nomfichier); //Permet de télécharge le fichier et indique son nom
    readfile($nomfichier); //Enregistre le contenu du fichier
	unlink($nomfichier); //Supprime le fichier du serveur
}
?>

