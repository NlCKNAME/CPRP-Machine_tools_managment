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
    </div>
    <nav>
		  <div style="width:75%; float:left; margin:5px;">
      <ul>

        <li><a href="doosan.php">DOOSAN</a></li>
        <li><a href="haas.php">HAAS</a></li>
		<li><a href="#">DMU</a></li>
        <li><a href="#">HAAS</a></li>
        <li><a href="#">TRANSMAB</a></li>
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