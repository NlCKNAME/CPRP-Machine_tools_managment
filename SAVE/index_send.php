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
	<img title="Lycée JB de BAUDRE" src="img/lycee.jpg" style="width: 200px; float:right" />
    <nav>
		<div style="width:75%; float:left; margin:5px;">
			<ul>
				<li><a href="doosan.php">DOOSAN<span><img title="DOOSAN lynx 220ly" src="img/doosan.jpg" style="width: 500px;" /></span></a></li>
				<li><a href="haas.php">HAAS<span><img title="HAAS vf1" src="img/haas.png" style="width: 500px;" /></span></a></li>
				<li><a href="transmab.php">TRANSMAB<span><img title="SOMAB TRANSMAB 200" src="img/transmab.jpg" style="width: 500px;" /></span></a></li>

				<li><a href="danobat.php">DANOBAT<span><img title="DANOBAT"  title="DANOBAT" src="img/danobat.jpg" style="width: 500px;" /></span></a></li> 
				<!--<li><a href="#">DMU<span><img title="DMU"  title="DMU" src="img/dmu.jpg" style="width: 500px;" /></span></a></li>-->
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
<font face="arial" size="7" color="BLUE">
				<b> <i>
					Connection to DANOBAT
				</i> </b>
			</font>
			
		
			
			<div style="border: 2px solid red; margin-left: 30%; margin-right: 30%;">
				<form enctype="multipart/form-data" action="Alt_send.php" method="POST" target="__URL__">
					File : <input name="file" id="file" type="file"></input><br>
					Name : <input name="Nom" id="Nom" type="text"></input></br>
					Nbr Prog : <input name="Nbr" id="Nbr" type="text"></input><br>
					<input type="submit" value="Envoyer" name="send" id="send">
				</form>
			</div>
			
			
			<div style="border: 2px solid red; margin-left: 30%; margin-right: 30%;">
			</div>
		
		</center>
<br />

	
  </div> 
</div>

</body>
</html>