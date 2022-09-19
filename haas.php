<?php
header('Content-Type: text/html; charset=utf-8');/*Encodage*/

if(!@include('fonction.php')){
echo '<div style="position:absolute; top:45%; left:40%; color:red;">Impossible d\'inclure fonction.php ...</div>';
exit;
}
$DEFAULT="\\\\HaasMachine\\DATA/"; /*Default redirection quand le script commence*/
$IMGFOLDER='img/file.png'; /*L'icon pour le dossier*/
$IMGFILE='img/fichier.gif'; /*Icon pour le fichier*/
$IMGCREATEFILE='img/filenew.png'; /*Fichier pour crée un fichier*/
$IMGUPLOAD='img/upload.png'; /*Fichier pour upload des fichier*/
$IMGCREATEFOLDER='img/folder-new.png';
$IMGRENAME='img/edit.png';
if(!isset($_GET['rename'])&&!isset($_GET['pathren'])&&!isset($_GET['en'])&&!isset($_GET['upload'])&&!isset($_POST['pathupload'])&&!isset($_GET['touch'])&&!isset($_GET['download'])&&/*Verifie si rien n'est appellé*/
!isset($_GET['delete'])&&!isset($_GET['deletedir'])&&!isset($_GET['path'])&&!isset($_GET['dir'])&&!isset($_FILES['fichier'])&&!isset($_GET['mkdir'])&&!isset
($_GET['pathmkdir']))
{
	header('location:?dir=');
}
if(isset($_GET['upload'])&&isset($_POST))
{
	
	if(!file_exists($_POST['pathupload'].$_FILES['fichier']['name'])){
$tmp_file = $_FILES['fichier']['tmp_name'];
$name_file = $_FILES['fichier']['name'];

    if( !is_uploaded_file($tmp_file) )
    {
        Erreur('Erreur lors du telechargement !');
		
		exit;
    }
	
	 if( !move_uploaded_file($tmp_file, $_POST['pathupload'].''. $name_file) )
    {

		Erreur('Erreur lors du deplacement du fichier !</div></body></html>');
		exit;
    }
	header('location:'.$_SERVER['HTTP_REFERER']);
	}
else{
	echo'<div class="wrapper row2">';
   echo'<div id="container" class="clear">';
echo"<br />";
	echo"Un fichier du même nom est déjà présent dans le répertoire. Veuillez le renommer ou le supprimer puis recommencez l'opération !";
	
// Erreur("Un fichier du même nom est déjà présent dans le répertoire. Veuillez le renommer ou le supprimer puis recommencez l'opération !");
echo"<center>";
echo'<form>';
echo'  <input type="button" value="Retour" onclick="history.go(-1)">';
echo'</form>';
echo"</center>";
exit;

}
	}
	



if(isset($_GET['touch'])&&!empty($_GET['touch'])&&isset($_GET['path'])&&!empty($_GET['path']))/*Permer de crée un fichier*/
{
 
 if(file_exists($_GET['path'].'/'.$_GET['touch']))
 {
	Erreur('Un fichier porte deja le nom : '.$_GET['touch'].' !');
	exit;
 }
 
 if(!@touch($_GET['path'].'/'.$_GET['touch']))
 {
     Erreur('Erreur l\'ors de la creation du fichier '.$_GET['touch'].'');
     exit;
 }

  $path = str_replace($DEFAULT,"",$_GET['path']);
 header('location:'.'?dir='.$path);/*Redirection a l'url precedent*/

}

if(isset($_GET['mkdir'])&&!empty($_GET['mkdir'])&&isset($_GET['pathmkdir'])&&!empty($_GET['pathmkdir']))
{
 if(file_exists($_GET['pathmkdir'].'/'.$_GET['mkdir'])&&is_dir($_GET['pathmkdir'].'/'.$_GET['mkdir']))
 {
  Erreur('Erreur un dossier porte deja se nom :'.$_GET['mkdir'].' ...');
  exit;
	}
 
 if(!@mkdir($_GET['pathmkdir'].'/'.$_GET['mkdir'],0755)){
     Erreur('Erreur l\'ors de la création du fichier '.$_GET['mkdir'].'!');
     exit;
 }
   $pathmkdir = str_replace($DEFAULT,"",$_GET['pathmkdir']);
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



if(isset($_GET['download'])&&!empty($_GET['download'])&&file_exists($_GET['download'])&&is_file($_GET['download']))/*Telecharge un fichier*/
{
  download($_GET['download']);/*....*/
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
  $dossier = str_replace("//","/",$dossier );
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
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
<title>Transfert de fichier</title>
<meta charset="iso-8859-1">
<link rel="stylesheet" media="screen" type="text/css" title="Design" href="file/style-explorateur.css" />
<script language="javascript" type="text/javascript" src="file/javascript.js"></script>

</head>

<body>
<div class="wrapper row1">
  <header id="header" class="clear">
    <div id="hgroup">
      <h1><a href="index.php">Interface de transfert de fichier</a></h1>
    </div><img title="Lycée"  title="Lycée" src="img/lycee.jpg" style="width: 200px; float:right" />

    <nav>
		  <div style="width:75%; float:left; margin:5px;">
      <ul>

        <li><a href="doosan.php">DOOSAN<span><img title="DOOSAN"  title="DOOSAN" src="img/doosan.jpg" style="width: 500px;" /></span></a></li>
		<!--<li><a href="#">DANOBAT<span><img title="DANOBAT"  title="DANOBAT" src="img/danobat.jpg" style="width: 500px;" /></span></a></li> -->
        <li><a href="haas.php" style=" color: #FF9900;">HAAS<span><img title="HAAS"  title="HAAS" src="img/haas.png" style="width: 500px;" /></span></a></li>
		<!--<li><a href="#">DMU<span><img title="DMU"  title="DMU" src="img/dmu.jpg" style="width: 500px;" /></span></a></li>-->
		<li><a href="transmab.php">TRANSMAB<span><img title="TRANSMAB"  title="TRANSMAB" src="img/transmab.jpg" style="width: 500px;" /></span></a></li>
		<li><a href="danobat.php">DANOBAT<span><img title="DANOBAT"  title="DANOBAT" src="img/danobat.jpg" style="width: 500px;" /></span></a></li>
		
		      </ul>
	</div>
	<div style="width:20%; float:left" align="right">
		<li><a href="#" onclick="display_('upload');"><img title="Envoyer un fichier"  title="Envoyer un fichier" src="<?php echo $IMGUPLOAD; ?>" /></a></li>
		<li><a href="#" onclick="display_('mkdir');"><img title="Cree un dossier"  title="Cree un dossier" src="<?php echo $IMGCREATEFOLDER; ?>" /></a></li>
		</div> 

    </nav>
  </header>
</div>
<!-- Gestionnaire de fichier -->
<div class="wrapper row2">
   <div id="container" class="clear">
<br />
<div style="float:right">
<?php
if(isset($_POST['delete'])&&!empty($_POST['delete'])&&isset($_POST['delete'])&&!empty($_POST['delete']))
{
$delete = $_POST['delete'];
}else{
	$delete = "NO";
}
if ($delete != "YES")
{
echo '<FORM ACTION="#" METHOD=POST>';
echo "<INPUT TYPE=HIDDEN SIZE=1 NAME='delete' VALUE='YES'>";
echo "<INPUT  TYPE=SUBMIT VALUE='Activer la suppression'>";
echo "</FORM>";
}else{
	echo '<FORM ACTION="#" METHOD=POST>';
echo "<INPUT TYPE=HIDDEN SIZE=1 NAME='delete' VALUE='No'>";
echo "<INPUT TYPE=SUBMIT VALUE='Desactiver la suppression'>";
echo "</FORM>";
}
?>
</div>
<?php

$f = readdir($handle);
$f = readdir($handle);
$lien=str_replace(" "," ",$f); /*Pour les espace fichier*/
$replien=str_replace(" "," ",$rep);/*idem pour les dossier*/

echo '<a href="?dir="><img alt="Dossier" src="'.$IMGFOLDER.'" />Retour à la racine</a><br />'; 
while ($f = readdir($handle)) { //Boucle qui enumere tout les fichier d'un repertoire
     $lien=str_replace(" ",' ',$f); /*Pour les espace fichier*/
	 $replien=str_replace(" ",' ',$rep);/*idem pour les dossier*/

echo '<p>';
  if(@is_dir($rep.'/'.$f)){ /*verifie si c'est un repertoire*/
	  if ($delete == "YES")
{
echo '<a href="?deletedir='.$replien.'/'.$lien.'" onclick="return confirm(\'Supprimer '.$f.' ?\');"><img alt="Supprimmer" title="/!\Supprimer/!\ " src="img/delete.gif" style="vertical-align:middle"/></a>';
}
     echo '<a href="?dir='.$_GET['dir'].'/'.$lien.'/"><img alt="Dossier" src="'.$IMGFOLDER.'" style="vertical-align:middle" />'.$f.'</a>';
	echo '&nbsp&nbsp&nbsp<a href="?dir='.$_GET['dir'].'&renom='.$lien.'" ><img title="Renommer"  title="Renommer" src="'.$IMGRENAME.'" style="vertical-align:middle"/></a>'; 
   }elseif(@is_file($rep.'/'.$f)){/*Verifie si c'est bien un fichier*/
   
	 	  if ($delete == "YES")
{
echo '<a href="?delete='.$replien.'/'.$lien.'" onclick="return confirm(\'Supprimer '.$f.' ?\');"><img alt="Supprimmer" title="/!\Supprimer/!\ " src="img/delete.gif" style="vertical-align:middle"/></a>';
}
	 echo '<img src="'.$IMGFILE.'" alt="Fichier" style="vertical-align:middle" />'.$f.'';
	 
	echo '&nbsp&nbsp&nbsp<a href="?dir='.$_GET['dir'].'&renom='.$lien.'" ><img title="Renommer"  title="Renommer" src="'.$IMGRENAME.'"style="vertical-align:middle" /></a>'; 
   
	 echo '&nbsp&nbsp&nbsp<a href="?download='.$replien.'/'.$lien.'" ><img alt="Recevoir" title="Recevoir un fichier " src="img/download.png"style="vertical-align:middle" /></a><br />';
	 	 
}
echo '</p>';
}
/*Crée le formulaire pour crée un fichier par default display:none affiche en cliquant en  haut*/
echo '<br />';

/* Formulaire pour upload un fichier */
echo '<div class="bulle" id="upload" style="display:none;">
<form method="post" enctype="multipart/form-data" action="?upload">
<input type="file" name="fichier" size="25">
<input type="submit" name="upload" value="Go">
<input type="hidden" name="pathupload" value="'.$replien.'" />
</form></div>';

/* Formulaire pour crée un dossier :)*/ 

echo '<div class="bulle" id="mkdir" style="display:none;"><form method="get" action="?" >
<img src="'.$IMGFOLDER.'" ></img><input type="text" name="mkdir"  title="Cree dossier" size="30" />
<input type="hidden" name="pathmkdir" value="'.$replien.'" />
</form></div>';

/* renommer */
if(isset($_GET['renom'])&&!empty($_GET['renom']))
	{
	echo '<div class="bulle" id="rename" style="display;"><form method="get" action="?" >
	<img src="'.$IMGRENAME.'"></img><input type="hidden" name="rename" value="'.$_GET['renom'].'" /> <input type="text" name="en"  title="Nom" size="10" /><input type="submit" value="Renommer" />
	<input type="hidden" name="pathren" value="'.$replien.'" />
	</form></div>';
	}
}
else{
	?>
	<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
<title>Transfert de fichier</title>
<meta charset="iso-8859-1">
<link rel="stylesheet" media="screen" type="text/css" title="Design" href="file/style-explorateur.css" />
<script language="javascript" type="text/javascript" src="file/javascript.js"></script>

</head>

<body>
<div class="wrapper row1">
  <header id="header" class="clear">
    <div id="hgroup">
      <h1><a href="index.php">Interface de transfert de fichier</a></h1>
    </div><img title="Lycée"  src="img/lycee.jpg" style="width: 200px; float:right" />

    <nav>
		  <div style="width:75%; float:left; margin:5px;">
      <ul>

        <li><a href="doosan.php">DOOSAN<span><img title="DOOSAN"  src="img/doosan.jpg" style="width: 500px;" /></span></a></li>
		<!--<li><a href="#">DANOBAT<span><img title="DANOBAT"  title="DANOBAT" src="img/danobat.jpg" style="width: 500px;" /></span></a></li> -->
        <li><a href="haas.php" style=" color: #FF9900;">HAAS<span><img title="HAAS" src="img/haas.png" style="width: 500px;" /></span></a></li>
		<!--<li><a href="#">DMU<span><img title="DMU"  title="DMU" src="img/dmu.jpg" style="width: 500px;" /></span></a></li>-->
		<li><a href="transmab.php">TRANSMAB<span><img title="TRANSMAB" src="img/transmab.jpg" style="width: 500px;" /></span></a></li>
		      </ul>
	</div>
    </nav>
  </header>
</div>
<!-- Gestionnaire de fichier -->
<div class="wrapper row2">
	<div id="container" class="clear">
		<br />
		<center>
			<h1>Connexion impossible avec le répertoire de travail. Veuillez contrôler l'etat de la machine ou contacter un responsable</h1>
		</center>
		<br />

	

<?php
}

?>
	
  </div> 
</div>

</body>
</html>