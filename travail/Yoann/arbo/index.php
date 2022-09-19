<?php
header('Content-Type: text/html; charset=utf-8');/*Encodage*/

/*
Programme par : kiki67100
le mardi 27 novembre 2007

Navigateur de fichier permet de crée , supprimmer , lister les fichier présent sur un serveur
*/

if(!@include('fonction.php')){
echo '<div style="position:absolute; top:45%; left:40%; color:red;">Impossible d\'inclure fonction.php ...</div>';
exit;
}
$DEFAULT="C:\machine\haas/"; /*Default redirection quand le script commence*/
$IMGFOLDER='img/file.png'; /*L'icon pour le dossier*/
$IMGFILE='img/fichier.gif'; /*Icon pour le fichier*/
$IMGCREATEFILE='img/filenew.png'; /*Image pour crée un fichier*/
$IMGCREATEFOLDER='img/folder-new.png';/*Image pour crée un nouveau dossier*/
$IMGRENAME='img/edit.png';/*Image pour renommer un fichier*/


if(!isset($_GET['rename'])&&!isset($_GET['pathren'])&&!isset($_GET['en'])&&!isset($_GET['upload'])&&!isset($_GET['touch'])&&/*Verifie si rien n'est appellé*/
!isset($_GET['delete'])&&!isset($_GET['deletedir'])&&!isset($_GET['path'])&&!isset($_GET['dir'])&&!isset($_FILES['fichier'])&&!isset($_GET['mkdir'])&&!isset
($_GET['pathmkdir']))
{
	header('location:?dir='); /*On redirige vers la racine*/
}

if(isset($_GET['touch'])&&!empty($_GET['touch'])&&isset($_GET['path'])&&!empty($_GET['path']))/*Permer de crée un fichier, on verifie que les paramètres sont bien passé et ne sont pas vide*/
{
 
 if(file_exists($_GET['path'].'/'.$_GET['touch'])) /*On verifie qu'un fichier ne porte pas déjà le nom*/
 {
	Erreur('Un fichier porte deja le nom : '.$_GET['touch'].' !'); /*On retourne qu'un fichier porte déjà le nom*/
	exit;
 }
 
 if(!@touch($_GET['path'].'/'.$_GET['touch'])) /*On crée le fichier et si il n'arrive pas à ce créer on affiche une erreur*/
 {
     Erreur('Erreur l\'ors de la creation du fichier '.$_GET['touch'].'');
     exit;
 }

  $path = str_replace($DEFAULT,"",$_GET['path']); /*On met en forme le chemin d'accès au nouveau fichier*/
 header('location:'.'?dir='.$path);/*Redirection a l'url precedent*/

}

if(isset($_GET['mkdir'])&&!empty($_GET['mkdir'])&&isset($_GET['pathmkdir'])&&!empty($_GET['pathmkdir']))/*Permer de crée un dossier, on verifie que les paramètres sont bien passé et ne sont pas vide*/
{
 if(file_exists($_GET['pathmkdir'].'/'.$_GET['mkdir'])&&is_dir($_GET['pathmkdir'].'/'.$_GET['mkdir'])) /*On regarde si le nom existe et si il s'agit d'un dossier*/
 {
  Erreur('Erreur un dossier porte deja se nom :'.$_GET['mkdir'].' ...');
  exit;
	}
 
 if(!@mkdir($_GET['pathmkdir'].'/'.$_GET['mkdir'],0755)){ /*On crée le dossier avec le formatage et si il n'y arrive pas on affiche une erreur */
     Erreur('Erreur l\'ors de la création du fichier '.$_GET['mkdir'].'!');
     exit;
 }
   $pathmkdir = str_replace($DEFAULT,"",$_GET['pathmkdir']);/*On met en forme le chemin d'accès pour retourner où on était*/
  header('location:?dir='.$pathmkdir);
}


if(isset($_GET['rename'])&&!empty($_GET['rename'])&&isset($_GET['pathren'])&&!empty($_GET['pathren'])&&isset($_GET['en'])&&!empty($_GET['en']))
{

if(!file_exists($_GET['pathren'].'/'.$_GET['rename']))
{
	Erreur('Fichier '.$_GET['rename'].' Introuvable ...');
	exit;
 }

if(file_exists($_GET['pathren'].'/'.$_GET['en']))
{
	Erreur('Un fichier porte deja le nom : '.$_GET['en'].' ...');
	exit;
	}
 
 if(!@rename($_GET['pathren'].'/'.$_GET['rename'],$_GET['pathren'].'/'.$_GET['en'])){
     Erreur('Erreur pour renommer '.$_GET['rename'].' en '.$_GET['en']);
     exit;
}
   $pathren = str_replace($DEFAULT,"",$_GET['pathren']);
  header('location:?dir='.$pathren);
}
if(isset($_GET['delete'])&&!empty($_GET['delete'])&&file_exists($_GET['delete'])&&is_file($_GET['delete']))/*Supprimé un fichier ...*/
{
  
  if(!@unlink($_GET['delete']))
  {
		Erreur('Erreur l\ors de la suppresion de '.$_GET['delete'].'');
		exit;
  }
  header('location:'.$_SERVER['HTTP_REFERER']);
}
if(isset($_GET['deletedir'])&&!empty($_GET['deletedir'])&&file_exists($_GET['deletedir'])&&is_dir($_GET['deletedir']))/*Supprimé un dossier ...*/
{
  $dossier = $_GET['deletedir'];
  $dosser = str_replace("//","/",$dosser );
$dir_iterator = new RecursiveDirectoryIterator($dossier);
$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::CHILD_FIRST);

// On supprime chaque dossier et chaque fichier	du dossier cible
foreach($iterator as $fichier){
	$fichier->isDir() ? rmdir($fichier) : unlink($fichier);
}

// On supprime le dossier cible
rmdir($dossier);

  
 header('location:'.$_SERVER['HTTP_REFERER']);
} 

$rep=$DEFAULT.$_GET['dir'];
$rep=str_replace("/..","/",$rep);
$rep=str_replace("//","/",$rep);
if(isset($rep)&&!empty($rep)&&file_exists($rep)&&is_dir($rep))/*Verifie la variable et bien un repertoire*/
{
$handle = @opendir($rep);/* Ouvre le repertoire */

if(!$handle)
  {
	print('Erreur l\'ors de l\'ouverture de '.$rep.' !');
	exit;
}
/**************************************------------------------HTML-------------------------*************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
<link rel="stylesheet" media="screen" type="text/css" title="Design" href="file/style-explorateur.css" />
<script language="javascript" type="text/javascript" src="file/javascript.js"></script> 
</head>
<body>
 <div style="float:right">
<a href="#" onclick="display_('touch');"><img title="Cree un fichier" src="<?php echo $IMGCREATEFILE; ?>" /></a><br />
<a href="#" onclick="display_('mkdir');"><img title="Cree un dossier" src="<?php echo $IMGCREATEFOLDER; ?>" /></a><br />
<a href="#" onclick="display_('rename');"><img title="Renommer"  src="<?php echo $IMGRENAME; ?>" /></a><br />

</div>  

<?php

$f = readdir($handle);
//$f = readdir($handle);
$lien=str_replace(" "," ",$f); /*Pour les espace fichier*/
$replien=str_replace(" "," ",$rep);/*idem pour les dossier*/


echo '<a href="./index.php"><img alt="Dossier" src="'.$IMGFOLDER.'" />Retour</a><br />'; 
while ($f = readdir($handle)) { //Boucle qui enumere tout les fichier d'un repertoire
     $lien=str_replace(" ",' ',$f); /*Pour les espace fichier*/
	 $replien=str_replace(" ",' ',$rep);/*idem pour les dossier*/
     
	 /*Pour la couleur du background ......................................*/
	 $i = 1;
	 if($i==0){  echo '<div class="color1">'; 
	 $i=1;
    }else{ echo '<div class="color2">';
    $i=0;
    }
	 /*Fin de la couleur ..................................*/
	 
  if(@is_dir($rep.'/'.$f)){ /*verifie si c'est un repertoire*/
	  
     echo '<a href="?deletedir='.$replien.'/'.$lien.'" onclick="return confirm(\'Supprimer '.$f.' ?\');"><img alt="Supprimmer" title="/!\Supprimer/!\ " src="img/delete.gif" /></a><a href="?dir='.$_GET['dir'].'/'.$lien.'/"><img alt="Dossier" src="'.$IMGFOLDER.'" />'.$f.'</a><br />'; 
   
   }elseif(@is_file($rep.'/'.$f)){/*Verifie si c'est bien un fichier*/
   
	 echo '<a href="?delete='.$replien.'/'.$lien.'" onclick="return confirm(\'Supprimer '.$f.' ?\');"><img alt="Supprimmer" title="/!\Supprimer/!\ " src="img/delete.gif" /></a><img src="'.$IMGFILE.'" alt="Fichier"/>'.$f.'  <a href="?download='.$replien.'/'.$lien.'" ><img alt="Telecharger" title="Telecharger " src="img/download.png" /></a><br />';
}
echo '</div>'."\n"; /*ferme la div pour la couleur.*/
/*Crée le formulaire pour crée un fichier par default display:none affiche en cliquant en  haut*/

}

/* Formulaire Pour crée un fichier */
echo '<div class="bulle" id="touch" style="display:none;"><form method="get" action="?" >
<img src="'.$IMGFILE.'"><input type="text" name="touch"  title="Fichier a cree" size="30" />
<input type="hidden" name="path" value="'.$replien.'" />
</form></div>';

/* Formulaire pour crée un dossier :)*/ 

echo '<div class="bulle" id="mkdir" style="display:none;"><form method="get" action="?" >
<img src="'.$IMGFOLDER.'" ><input type="text" name="mkdir"  title="Cree dossier" size="30" />
<input type="hidden" name="pathmkdir" value="'.$replien.'" />
</form></div>';

/* renommer */

echo '<div class="bulle" id="rename" style="display:none;"><form method="get" action="?" >
<img src="'.$IMGRENAME.'"><input type="text" name="rename"  title="Renommer ?" size="10" /> en <input type="text" name="en"  title="en" size="10" /><input type="submit" value="go" />
<input type="hidden" name="pathren" value="'.$replien.'" />
</form></div>';
}
else{
	print("Impossible d'acceder aux fichiers !!");
}
	



?>
</body>
</html>
