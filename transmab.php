<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
<title>Transfert de fichier</title>
<meta charset="iso-8859-1">
<link rel="stylesheet" media="screen" type="text/css" title="Design" href="file/style-explorateur.css" />

</head>
<body>
<div class="wrapper row1">
  <header id="header">
    <div id="hgroup">
      <h1><a href="index.php">Interface de transfert de fichier</a></h1>
    </div><img src="img/lycee.jpg" style="width: 200px; float:right" />
    <nav>
		  <div style="width:75%; float:left; margin:5px;">
      <ul>

        <li><a href="doosan.php">DOOSAN<span><img src="img/doosan.jpg" style="width: 500px;" /></span></a></li>
		<!--<li><a href="#">DANOBAT<span><img src="img/danobat.jpg" style="width: 500px;" /></span></a></li> -->
        <li><a href="haas.php">HAAS<span><img src="img/haas.png" style="width: 500px;" /></span></a></li>
		<!--<li><a href="#">DMU<span><img src="img/dmu.jpg" style="width: 500px;" /></span></a></li>-->
		<li><a href="transmab.php" style=" color: #FF9900;">TRANSMAB<span><img src="img/transmab.jpg" style="width: 500px;" /></span></a></li>
		<li><a href="danobat.php">DANOBAT<span><img title="DANOBAT"  title="DANOBAT" src="img/danobat.jpg" style="width: 500px;" /></span></a></li>
	  </ul>
	</div>
	
    </nav>
  </header>
</div>

<!-- Gestionnaire de fichier -->
<div class="wrapper row2">
   <div id="container">
<br/>

<center>
	<h1> <font color="#229954">Envoyer un programme</font></h1><br/>
	<img src="img/envoi.jpg" style="width: 400px" /><br/><br/>
	
	<form method="post" enctype="multipart/form-data" action="file/fonction_envoi.php">
		<p>
			<input type="file" name="fichier">
			<b><input type="button" value="Verification"><span><img src="img/envoyer.png" style="width: 400px;" /></span></b>
			<input type="submit" name="upload" value="Envoyer">
			<br/><br/><br/><br/><br/><br/><br/>
		</p>
	</form>
	
	<h1> <font color="#229954">Recevoir un programme</font></h1><br/>
	<img src="img/reception.jpg" style="width: 400px" /><br/><br/>
	
	<form action="file/socket_reception.php" method="post">
		<p>
			Choisissez un nom : <input type="text" name="nom" >
			<input type="submit" value="Cliquez">
			<c ><input type="button" value="Recevoir"><span><img src="img/recevoir.png" style="width: 400px;" /></span></c>
		</p>
	</form>
	
</center>
<br/>

	
  </div> 
</div>

</body>
</html>