<?php
function GetFileName ($path) /*Permet d'extraire le nom d'un fichier via le chemin*/
{
	$name=explode("/", $path);
	return $name[sizeof($name)-1];
}

function download ($file)/*Fonction download permet de télécharger un fichier */
{
	$name=GetFileName($file);/*Extraire le nom via la fonction GetFileName*/
	header('Content-disposition: attachement; filename=' .$name);/*Indique le nom*/

	
}	

if(isset($_GET['download']))/*Telecharge un fichier (si le parametre "download" est rempli)*/
{
	
	download($_GET['download']);/*....*/
}
	?>

<a href="?download=C:\wamp64\www\Jeremy/FRANCK.txt">Telecharger</a><br />


