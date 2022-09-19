<?php
function GetFileName ($path) /*Permet d'extraire le nom d'un fichier via le chemin*/
{
	$name=explode("/", $path);
	return $name[sizeof($name)-1];
}

function download ($file)/*Fonction download permet de télécharger un fichier */
{
	$name=GetFileName($file);/*Extraire le nom via la fonction GetFileName*/

/*
Modifie l'header forcer le téléchargement au client, au fichier desirer
*/
	header('Content-disposition: attachement; filename=' .$name);/*Indique le nom*/
	header('Content-Type: application/froce-download');/*Indique le type*/
	header('Content-Length: '.filesize($file));/*Indique la taille pour permettre au client de savoir le % de téléchargement ceci n'est pas obligatoire . */
	header('Pragma: no-cache');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0, public');
	header('Expires: 0');
	readfile($file); /*Lit le fichier */
	exit; /*On quitte pour ne rien envoyer d'autre */
}	

if(isset($_GET['download']))/*Telecharge un fichier (si le parametre "download" est rempli)*/
{
	
	download($_GET['download']);/*....*/
}
	?>

<a href="?download=C:\wamp64\www\Jeremy/FRANCK.txt">Telecharger</a><br />


