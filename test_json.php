<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<title>Transfert de fichier</title>
	<meta charset="iso-8859-1">
	<link rel="stylesheet" media="screen" type="text/css" title="Design" href="file/style-explorateur.css" />
	<script language="javascript" type="text/javascript" src="file/javascript.js"></script>
</head>

<script>
	<?php

		session_start();
		
		if(!isset($_SESSION['username']))
		{
			header("location: index.php");
			exit;
		}

		$homepage = file_get_contents('./file.json');
		echo " var data = ".$homepage.";";
		if (!isset($_SESSION['username'])) {
		    echo "var session = 0;";
		}else{
			echo "var session = 1;";
		}
	?>
	var data2 = data;

	console.log(data);
	console.log(data[0].machine[0].ip);
</script>

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
		<div>
			<a href="login.php">Connexion</a>
		</div>
		
    </nav>
  </header>
</div>
<!-- Gestionnaire de fichier -->
</font>



<div class="wrapper row2">
   <div id="container" class="clear">
<br />
<center>

<?php
function getBrowser() { 
  $u_agent = $_SERVER['HTTP_USER_AGENT'];
  $bname = 'Unknown';
 
  if(preg_match('/Trident/i',$u_agent)){
    $bname = 'IE';
    $ub = "MSIE";
  }
  else
  {
	   $bname = '0';
		$ub = "0";
  }

  return array(
    'userAgent' => $u_agent,
    'name'      => $bname,

  );
} 
?>



  



			<font face="arial" size="7" color="BLUE">
							<b> <i>
								Paramètres des Machines 
							</i> </b>
			</font>







			<BR>
			<BR>

			<div style="border: 2px solid black; margin-left: 30%; margin-right: 30%;">
			</br>
				<form enctype="multipart/form-data" action="Alt_send.php" method="POST" target="__URL__">
					<select id="select2">
						<option>Sélectionner une machine</option>
					</select><br><BR>
					Adresse IP : <input name="file" id="file" type="text" required></input><br><BR>
					Nom : <input name="Nom" id="Nom" type="text" required></input></br><BR>
				</form>
				<button onclick="update()">Mettre à jour</button> 
			</div>
		</div>
		<button style="float: right;" onclick="window.location.href = 'danobat.php';">Retour</button>
	</center>
	<br />
  </div> 
</div>



<script type="text/javascript">

	var sel = document.getElementById('select2');

	window.addEventListener("load",function(){
		for (var key in data[0].machine) {
		  if (data[0].machine.hasOwnProperty(key)) {
		    var opt = document.createElement('option');
		    opt.innerHTML = data[0].machine[key].nom;
		    opt.value = data[0].machine[key].nom;
		    sel.appendChild(opt);
		  }
		}
	},false);

	document.getElementById('file')
		.addEventListener('change', function() {
		var position = (sel.selectedIndex) - 1;
		if(position >= 0)
		{
			data2[0].machine[position].ip = document.getElementById("file").value;
			console.log(data);
		}
	})

	document.getElementById('Nom')
		.addEventListener('change', function() {
		var position = (sel.selectedIndex) - 1;
		if(position >= 0)
		{
			data2[0].machine[position].nom = document.getElementById("Nom").value;
			console.log(data);
		}
	})


	document.getElementById('select2') //On sélectionne l'element avec l'ID "Nbr"
		.addEventListener('change', function() { //Quand on entre un character dans le champ
			var data = document.getElementById("select2").value;
			var position = (sel.selectedIndex) - 1;
			if(position >= 0)
			{
				document.getElementById("file").value = data2[0].machine[position].ip;
				document.getElementById("Nom").value = data2[0].machine[position].nom;
			}else{
				document.getElementById("file").value = '';
				document.getElementById("Nom").value = '';
			}
	})


	document.getElementById('file') //On sélectionne l'element avec l'ID "Nbr"
		.addEventListener('input', function() { //Quand on entre un character dans le champ
		
			var data = document.getElementById("file").value; //On récupère la valeur du champ "Nbr"
			
			if(data.length != 6) //Si le nombre characters est strictement inférieur à 6
			{
				document.getElementById("file").style.border = '3px solid red';
			}else{
				document.getElementById("file").style.border = '3px solid green';
				
				var number = "P" + document.getElementById("file").value; //On récupère le nom du fichier
			}	
	})

	function update() {
		window.location.replace("./edit_json.php?json=" + JSON.stringify(data2));
	}

</script>

</body>
</html>