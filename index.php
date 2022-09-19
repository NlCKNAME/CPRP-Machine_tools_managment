<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<title>Transfert de fichier</title>
	<meta charset="iso-8859-1">
	<link rel="stylesheet" media="screen" type="text/css" title="Design" href="file/style-explorateur.css" />
	<script language="javascript" type="text/javascript" src="file/javascript.js"></script>
	<?php
		session_start();	

		// Check if the user is not logged in, then redirect the user to login page

		if (!isset($_SESSION['username'])) {
		    echo "<script>var session = 0;</script>";
		}else{
			echo "<script>var session = 1;</script>";
		}

	?>
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
				<li><a href="#">DMU<span><img title="DMU"  title="DMU" src="img/dmu.jpg" style="width: 500px;" /></span></a></li>
			</ul>
		</div>
		<div id="defaultPage">
			<a href="login.php">Connexion</a><br>
		</div>
		<div id="adminPage">
			<a href="logout.php">Deconnexion</a><a style="margin-left: 30px;" href="test_json.php">Page administrateur</a>
		</div>
    </nav>
  </header>
</div>
<!-- Gestionnaire de fichier -->
<div class="wrapper row2">
   <div id="container" class="clear">
<br />
<center>
<h1>Veuillez selectionner une machine.</h1>
</BR></BR>




<table cellspacing=10>



	<tr>
	
		<td align="center"><a href="doosan.php"> <img src="img\doosan.jpg" height="302" width="420" > <BR> DOOSAN <a></td>
		<td align="center"><a href="haas.php">  <img src="img\haas.png" height="302" width="420"> <BR> HAAS<a></td> 
		
	</tr>
	<tr>
		<td align="center"> <a href="tramsmab.php"> <img src="img\transmab.jpg" height="302" width="420"> <BR>  TRANSMAB <a></td>		
		<td align="center"> <a href="danobat.php"> <img src="img\danobat.jpg" height="302" width="420"> <BR>  DANOBAT <a></td>
	</tr>
	<tr>	
		<td align="center"> <a href="dmu.php"><img src="img\dmu.jpg"height="302" width="420"> <BR>  DMU <a></td> 
		<!--<td align="center"> <img src="orange.jpg" height="302" width="420""> <BR> </td>-->

	</tr>


</table>
</center>
<br />

	
  </div> 
</div>

<script>
	if(session === 0)
	{
		document.getElementById("adminPage").style.display = "none";
		document.getElementById("defaultPage").style.display = "block";
	}else{
		document.getElementById("adminPage").style.display = "block";
		document.getElementById("defaultPage").style.display = "none";
	}
</script>

</body>
</html>