<?php
//Cr�ation d'un socket TCP
if(!($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)))
{
    $erreur = socket_last_error();	//Retourne la derni�re erreur g�n�r�e par le socket
    $msgerreur = socket_strerror($erreur);	//Retourne le message d'erreur correspondant � l'erreur rencontr�e
     
    exit("Impossible de cr�er le socket: [$erreur] $msgerreur \n");	//Termine le script courant et affiche un message
}

 //Connexion au socket
if(!socket_connect($socket, '172.19.175.174', 1470))
{
    $erreur = socket_last_error();
    $msgerreur = socket_strerror($erreur);
     
    exit("Impossible de se connecter: [$erreur] $msgerreur \n");
}

//R�ception des donn�es
$buf = '';
while(($bytes = socket_recv($socket, $t_buf, 48, 0)) !=false)
{
			
		$t_buf=str_replace("\0","",$t_buf);
		$buf .= $t_buf;		//Concatenation des donn�es re�ues

	if ($bytes != 48)	//Fin de la boucle quand toutes les donn�es ont �t� transmise
		break;
}
socket_close($socket);

//Cr�er un fichier sur le serveur avec les donn�es re�ues
$nomfichier = $_POST['nom'] . ".txt";
$fichier = fopen($nomfichier, 'w+'); //Cr�er le fichier et l'ouvre en lecture et �criture
fwrite($fichier, $buf); //Copie le contenu de $buf dans le fichier
fclose($fichier);

//T�l�charge le fichier sur le PC
if (file_exists($nomfichier)) 
{
    header('Content-disposition: attachment; filename='.$nomfichier); //Permet de t�l�charge le fichier et indique son nom
    readfile($nomfichier); //Enregistre le contenu du fichier
	unlink($nomfichier); //Supprime le fichier du serveur
}
?>

