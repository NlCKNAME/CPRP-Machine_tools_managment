Explorateur de fichier php--------------------------
Url     : http://codes-sources.commentcamarche.net/source/44888-explorateur-de-fichier-phpAuteur  : kiki67100Date    : 08/08/2013
Licence :
=========

Ce document intitulé « Explorateur de fichier php » issu de CommentCaMarche
(codes-sources.commentcamarche.net) est mis à disposition sous les termes de
la licence Creative Commons. Vous pouvez copier, modifier des copies de cette
source, dans les conditions fixées par la licence, tant que cette note
apparaît clairement.

Description :
=============

Un petit explorateur de fichier en php
<br />
<br />Je trouve qu'il est pratiq
ue je l'utilise assez souvent
<br />
<br />MAJ regulierement
<br /><a name='s
ource-exemple'></a><h2> Source / Exemple : </h2>
<br /><pre class='code' data-
mode='basic'>
&lt;?php
header('Content-Type: text/html; charset=utf-8');/*Enco
dage*/

/*
Programme par : kiki67100
le mardi 27 novembre 2007

Navigateur
 de fichier permet de crée , supprimmer , lister les fichier présent sur un serv
eur

<ul><li>/</li></ul>

if(!@include('fonction.php')){
echo '&lt;div styl
e=&quot;position:absolute; top:45%; left:40%; color:red;&quot;&gt;Impossible d\'
inclure fonction.php ...&lt;/div&gt;';
exit;
}

$DEFAULT=$_SERVER['DOCUMENT_
ROOT']; /*Default redirection quand le script commence*/
$IMGFOLDER='img/file.p
ng'; /*L'icon pour le dossier*/
$IMGFILE='img/fichier.gif'; /*Icon pour le fich
ier*/
$IMGCREATEFILE='img/filenew.png'; /*Fichier pour crée un fichier*/
$IMGU
PLOAD='img/upload.gif'; /*Fichier pour upload des fichier*/
$IMGCREATEFOLDER='i
mg/folder-new.png';
$IMGSEARCH='img/search.png';
$IMGRENAME='img/edit.png';


if(!isset($_GET['rename'])&amp;&amp;!isset($_GET['pathren'])&amp;&amp;!isset($_
GET['en'])&amp;&amp;!isset($_GET['upload'])&amp;&amp;!isset($_POST['pathupload']
)&amp;&amp;!isset($_GET['touch'])&amp;&amp;!isset($_GET['download'])&amp;&amp;/*
Verifie si rien n'est appellé*/
!isset($_GET['delete'])&amp;&amp;!isset($_GET['
path'])&amp;&amp;!isset($_GET['dir'])&amp;&amp;!isset($_FILES['fichier'])&amp;&a
mp;!isset($_GET['mkdir'])&amp;&amp;!isset
($_GET['pathmkdir']))
{
	header('lo
cation:?dir='.$DEFAULT);
}

if(isset($_GET['upload'])&amp;&amp;isset($_POST)&
amp;&amp;!file_exists($_POST['pathupload'].$_FILES['fichier']['name']))
{
$tmp
_file = $_FILES['fichier']['tmp_name'];
$name_file = $_FILES['fichier']['name']
;

    if( !is_uploaded_file($tmp_file) )
    {
        Erreur('Erreur lors 
du telechargement !');
		
		exit;
    }
	
	 if( !move_uploaded_file($tmp_fi
le, $_POST['pathupload'].'/'. $name_file) )
    {

		Erreur('Erreur lors du d
eplacement du fichier !&lt;/div&gt;&lt;/body&gt;&lt;/html&gt;');
		exit;
    }


	header('location:'.$_SERVER['HTTP_REFERER']);
}

if(isset($_GET['touch']
)&amp;&amp;!empty($_GET['touch'])&amp;&amp;isset($_GET['path'])&amp;&amp;!empty(
$_GET['path']))/*Permer de crée un fichier*/
{
 
 if(file_exists($_GET['path'
].'/'.$_GET['touch']))
 {
	Erreur('Un fichier porte deja le nom : '.$_GET['tou
ch'].' !');
	exit;
 }
 
 if(!@touch($_GET['path'].'/'.$_GET['touch']))
 {

     Erreur('Erreur l\'ors de la creation du fichier '.$_GET['touch'].'');
    
 exit;
 }
  
 header('location:'.'?dir='.$_GET['path']);/*Redirection a l'url
 precedent*/

}

if(isset($_GET['mkdir'])&amp;&amp;!empty($_GET['mkdir'])&am
p;&amp;isset($_GET['pathmkdir'])&amp;&amp;!empty($_GET['pathmkdir']))
{
 if(fi
le_exists($_GET['pathmkdir'].'/'.$_GET['mkdir'])&amp;&amp;is_dir($_GET['pathmkdi
r'].'/'.$_GET['mkdir']))
 {
  Erreur('Erreur un dossier porte deja se nom :'.$
_GET['mkdir'].' ...');
  exit;
	}
 
 if(!@mkdir($_GET['pathmkdir'].'/'.$_GET
['mkdir'],0755)){
     Erreur('Erreur l\'ors de la création du fichier '.$_GET[
'mkdir'].'!');
     exit;
 }
  header('location:?dir='.$_GET['pathmkdir']);

}

if(isset($_GET['rename'])&amp;&amp;!empty($_GET['rename'])&amp;&amp;isset($
_GET['pathren'])&amp;&amp;!empty($_GET['pathren'])&amp;&amp;isset($_GET['en'])&a
mp;&amp;!empty($_GET['en']))
{

if(!file_exists($_GET['pathren'].'/'.$_GET['r
ename']))
{
	Erreur('Fichier '.$_GET['rename'].' Introuvable ...');
	exit;
 
}

if(file_exists($_GET['pathren'].'/'.$_GET['en']))
{
	Erreur('Un fichier p
orte deja le nom : '.$_GET['en'].' ...');
	exit;
	}
 
 if(!@rename($_GET['pa
thren'].'/'.$_GET['rename'],$_GET['pathren'].'/'.$_GET['en'])){
     Erreur('Er
reur pour renommer '.$_GET['rename'].' en '.$_GET['en']);
     exit;
}

  he
ader('location:?dir='.$_GET['pathren']);
}

if(isset($_GET['download'])&amp;&
amp;!empty($_GET['download'])&amp;&amp;file_exists($_GET['download'])&amp;&amp;i
s_file($_GET['download']))/*Telecharge un fichier*/
{
  download($_GET['downlo
ad']);/*....*/
}

if(isset($_GET['delete'])&amp;&amp;!empty($_GET['delete'])&
amp;&amp;file_exists($_GET['delete'])&amp;&amp;is_file($_GET['delete']))/*Suppri
mé un fichier ...*/
{
  
  if(!@unlink($_GET['delete']))
  {
		Erreur('Erre
ur l\ors de la suppresion de '.$_GET['delete'].'');
		exit;
  }
  header('loc
ation:'.$_SERVER['HTTP_REFERER']);
}

if(isset($_GET['dir'])&amp;&amp;!empty(
$_GET['dir'])&amp;&amp;file_exists($_GET['dir'])&amp;&amp;is_dir($_GET['dir']))/
*Verifie la variable et bien un repertoire*/
{
$rep=$_GET['dir'];
$rep=str_re
place(&quot;//&quot;,&quot;/&quot;,$rep);
$handle = @opendir($rep);/* Ouvre le 
repertoire */

if(!$handle)
  {
	Erreur('Erreur l\'ors de l\'ouverture de '.
$rep.' !');
	exit;
}

/**************************************---------------
---------HTML-------------------------*************************************/
?&
gt;
&lt;!DOCTYPE html PUBLIC &quot;-//W3C//DTD XHTML 1.0 Strict//EN&quot; &quot
;<a href='http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd' target='_blank'>htt
p://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd</a>&quot;&gt;
&lt;html xmlns=&qu
ot;<a href='http://www.w3.org/1999/xhtml' target='_blank'>http://www.w3.org/1999
/xhtml</a>&quot; xml:lang=&quot;fr&quot; &gt;
&lt;head&gt;
&lt;link rel=&quot;
stylesheet&quot; media=&quot;screen&quot; type=&quot;text/css&quot; title=&quot;
Design&quot; href=&quot;file/style-explorateur.css&quot; /&gt;
&lt;script langu
age=&quot;javascript&quot; type=&quot;text/javascript&quot; src=&quot;file/javas
cript.js&quot;&gt;&lt;/script&gt; 
&lt;/head&gt;
&lt;body&gt;
&lt;div class=&
quot;opensrc&quot;&gt;&lt;img src=&quot;<a href='http://upload.wikimedia.org/wik
ipedia/commons/thumb/4/42/Opensource.svg/288px-Opensource.svg.png' target='_blan
k'>http://upload.wikimedia.org/wikipedia/commons/thumb/4/42/Opensource.svg/288px
-Opensource.svg.png</a>&quot; /&gt;&lt;/div&gt;
&lt;div style=&quot;float:right
&quot;&gt;
&lt;a href=&quot;#&quot; onclick=&quot;display_('touch');&quot;&gt;&
lt;img title=&quot;Cree un fichier&quot;  title=&quot;Cree un fichier&quot; src=
&quot;&lt;?php echo $IMGCREATEFILE; ?&gt;&quot; /&gt;&lt;/a&gt;&lt;br /&gt;
&lt
;a href=&quot;#&quot; onclick=&quot;display_('upload');&quot;&gt;&lt;img title=&
quot;Telecharger un fichier&quot;  title=&quot;Telecharger un fichier&quot; src=
&quot;&lt;?php echo $IMGUPLOAD; ?&gt;&quot; /&gt;&lt;/a&gt;&lt;br /&gt;
&lt;a h
ref=&quot;#&quot; onclick=&quot;display_('mkdir');&quot;&gt;&lt;img title=&quot;
Cree un dossier&quot;  title=&quot;Cree un dossier&quot; src=&quot;&lt;?php echo
 $IMGCREATEFOLDER; ?&gt;&quot; /&gt;&lt;/a&gt;&lt;br /&gt;
&lt;a href=&quot;#&q
uot; onclick=&quot;display_('search');&quot;&gt;&lt;img title=&quot;Chercher&quo
t;  title=&quot;Chercher&quot; src=&quot;&lt;?php echo $IMGSEARCH; ?&gt;&quot; /
&gt;&lt;/a&gt;&lt;/span&gt;&lt;br /&gt;
&lt;a href=&quot;#&quot; onclick=&quot;
display_('rename');&quot;&gt;&lt;img title=&quot;Renommer&quot;  title=&quot;Ren
ommer&quot; src=&quot;&lt;?php echo $IMGRENAME; ?&gt;&quot; /&gt;&lt;/a&gt;&lt;/
span&gt;&lt;br /&gt;

&lt;/div&gt;
&lt;/body&gt;
&lt;/html&gt;
&lt;?php
wh
ile ($f = readdir($handle)) { //Boucle qui enumere tout les fichier d'un reperto
ire
     $lien=str_replace(&quot; &quot;,'%20',$f); /*Pour les espace fichier*/

	 $replien=str_replace(&quot; &quot;,'%20',$rep);/*idem pour les dossier*/
  
   
	 /*Pour la couleur du background ......................................*/

	 if($i==0){  echo '&lt;div class=&quot;color1&quot;&gt;'; 
	 $i=1;
    }else
{ echo '&lt;div class=&quot;color2&quot;&gt;';
    $i=0;
    }
	 /*Fin de la 
couleur ..................................*/
	 
  if(@is_dir($rep.'/'.$f)){ /*
verifie si c'est un repertoire*/
	  
     echo '&lt;a href=&quot;?dir='.$repli
en.'/'.$lien.'&quot;&gt;&lt;img alt=&quot;Dossier&quot; src=&quot;'.$IMGFOLDER.'
&quot; /&gt;'.$f.'&lt;/a&gt;&lt;br /&gt;'; 
   
   }elseif(@is_file($rep.'/'.$
f)){/*Verifie si c'est bien un fichier*/
   
	  echo '&lt;img src=&quot;'.$IMG
FILE.'&quot; alt=&quot;Fichier&quot;/&gt;'.$f.'&lt;a href=&quot;?delete='.$repli
en.'/'.$lien.'&quot; onclick=&quot;return confirm(\'Supprimer '.$f.' ?\');&quot;
&gt;&lt;img alt=&quot;Supprimmer&quot; title=&quot;/!\Supprimer/!\ &quot; src=&q
uot;img/delete.gif&quot; /&gt;&lt;/a&gt;&lt;a href=&quot;?download='.$replien.'/
'.$lien.'&quot; &gt;&lt;img alt=&quot;Telecharger&quot; title=&quot;Telecharger 
&quot; src=&quot;img/download.png&quot; /&gt;&lt;/a&gt;&lt;br /&gt;';
}
echo '
&lt;/div&gt;'.&quot;\n&quot;; /*ferme la div pour la couleur.*/
/*Crée le formu
laire pour crée un fichier par default display:none affiche en cliquant en  haut
*/

}
}

/*Formulaire Pour crée un fichier */
echo '&lt;div class=&quot;bu
lle&quot; id=&quot;touch&quot; style=&quot;display:none;&quot;&gt;&lt;form metho
d=&quot;get&quot; action=&quot;?&quot; &gt;
&lt;img src=&quot;'.$IMGFILE.'&quot
;&gt;&lt;/img&gt;&lt;input type=&quot;text&quot; name=&quot;touch&quot;  title=&
quot;Fichier a cree&quot; size=&quot;30&quot; /&gt;
&lt;input type=&quot;hidden
&quot; name=&quot;path&quot; value=&quot;'.$replien.'&quot; /&gt;
&lt;/form&gt;
&lt;/div&gt;';

/*Formulaire pour upload un fichier*/
echo '&lt;div class=&qu
ot;bulle&quot; id=&quot;upload&quot; style=&quot;display:none;&quot;&gt;
&lt;fo
rm method=&quot;post&quot; enctype=&quot;multipart/form-data&quot; action=&quot;
?upload&quot;&gt;
&lt;input type=&quot;file&quot; name=&quot;fichier&quot; size
=&quot;25&quot;&gt;
&lt;input type=&quot;submit&quot; name=&quot;upload&quot; v
alue=&quot;Go&quot;&gt;
&lt;input type=&quot;hidden&quot; name=&quot;pathupload
&quot; value=&quot;'.$replien.'&quot; /&gt;
&lt;/form&gt;&lt;/div&gt;';

/*Fo
rmulaire pour crée un dossier :)*/

echo '&lt;div class=&quot;bulle&quot; id=&
quot;mkdir&quot; style=&quot;display:none;&quot;&gt;&lt;form method=&quot;get&qu
ot; action=&quot;?&quot; &gt;
&lt;img src=&quot;'.$IMGFOLDER.'&quot; &gt;&lt;/i
mg&gt;&lt;input type=&quot;text&quot; name=&quot;mkdir&quot;  title=&quot;Cree d
ossier&quot; size=&quot;30&quot; /&gt;
&lt;input type=&quot;hidden&quot; name=&
quot;pathmkdir&quot; value=&quot;'.$replien.'&quot; /&gt;
&lt;/form&gt;&lt;/div
&gt;';

/*renommer*/

echo '&lt;div class=&quot;bulle&quot; id=&quot;rename&
quot; style=&quot;display:none;&quot;&gt;&lt;form method=&quot;get&quot; action=
&quot;?&quot; &gt;
&lt;img src=&quot;'.$IMGRENAME.'&quot;&gt;&lt;/img&gt;&lt;in
put type=&quot;text&quot; name=&quot;rename&quot;  title=&quot;Renommer ?&quot; 
size=&quot;10&quot; /&gt; en &lt;input type=&quot;text&quot; name=&quot;en&quot;
  title=&quot;en&quot; size=&quot;10&quot; /&gt;&lt;input type=&quot;submit&quot
; value=&quot;go&quot; /&gt;
&lt;input type=&quot;hidden&quot; name=&quot;pathr
en&quot; value=&quot;'.$replien.'&quot; /&gt;
&lt;/form&gt;&lt;/div&gt;';

ec
ho '&lt;div class=&quot;bulle&quot; id=&quot;search&quot; style=&quot;display:no
ne;&quot;&gt;
&lt;img src='.$IMGSEARCH.'&gt;&lt;/img&gt;&lt;input type=&quot;te
xt&quot; size=&quot;20&quot; OnKeyUp=&quot;f(this.value);&quot; /&gt;&lt;br&gt;&
lt;div id=&quot;recherche&quot;&gt;&lt;/div&gt;&lt;/div&gt;
';

?&gt;
&lt;/b
ody&gt;
&lt;/html&gt;
</pre>
<br /><a name='conclusion'></a><h2> Conclusion :
 </h2>
<br />Voil&agrave; J'ai les am&eacute;liorer j'attent vos commentaire .
...
