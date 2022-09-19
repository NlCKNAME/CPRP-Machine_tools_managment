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
        <li><a href="haas.php">HAAS<span><img title="HAAS"  title="HAAS" src="img/haas.png" style="width: 500px;" /></span></a></li>
		<!--<li><a href="#">DMU<span><img title="DMU"  title="DMU" src="img/dmu.jpg" style="width: 500px;" /></span></a></li>-->
		<li><a href="transmab.php" style=" color: #FF9900;">TRANSMAB<span><img title="TRANSMAB"  title="TRANSMAB" src="img/transmab.jpg" style="width: 500px;" /></span></a></li>
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
<form action="file/socket_reception.php" method="post">
	<p>
		Nom du fichier à recevoir : <input type="text" name="nom" >
		<input type="submit" value="Valider">
	</p>
	
</form>
<form method="post" enctype="multipart/form-data" action="file/fonction_envoi.php">
	<p>
		<input type="file" name="fichier" >
		<input type="submit" name="upload" value="Valider">
	</p>
</form>
</center>
<br />

	
  </div> 
</div>

</body>
</html>