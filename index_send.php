<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<title>Transfert de fichier</title>
	<meta charset="iso-8859-1">
	<link rel="stylesheet" media="screen" type="text/css" title="Design" href="file/style-explorateur.css" />
	<script language="javascript" type="text/javascript" src="file/javascript.js"></script>
</head>

<?php
		error_reporting(E_ERROR | E_PARSE);

	//----------------------------------------------------------------------		
		function Start()
		{
			global $socket ;
			global $result ;

			$service_port = 3873; // port de connexion sur le danobat
			$address = gethostbyname('172.19.175.172'); // @IP du tour danobat
			
			/* Crée un socket TCP/IP. */
			$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if ( $socket === true) {
				echo "socket_create() a échoué : raison :  " . socket_strerror(socket_last_error()) . "\n";
			} else {
		
			}
		
			$result = socket_connect($socket, $address, $service_port);
			if ($result === false) {
				echo '<br>';
				echo '<p style="font-size:160%;">';
				echo "Une tentative de connexion a échouée, la Danobat est trés certainement éteinte";
				echo '</p>';
			} else {

			}
		}

//----------------------------------------------------------------------		
			function Get_Dir(){
				
				global $socket, $result ;
				global $tabnom;
				global $taille;
				$count = 0;
				$z=0;
				
				echo '<br>';
				
				
					$tab = array ();
							
							$l=0;
							$k=0;
						
				
				for($j = 0; $j < 1000; $j += 12) //NBre de tramme (incrementation 12 en 12)
				{
					
					if ($j < 1)
					{
						$in = chr(0x00).chr(0x10).chr(0x01).chr(0x52).chr(0x2c).chr(0x50).chr(0x52).chr(0x47).chr(0x2c).chr(0x44).chr(0x49).chr(0x52).chr(0x2c).chr(0x50).chr(0x2c).chr(0x30).chr(0x2c).chr(0x03); 
					}
					elseif($j > 1 && $j < 100)
					{
						$in = chr(0x00).chr(0x11).chr(0x01).chr(0x52).chr(0x2c).chr(0x50).chr(0x52).chr(0x47).chr(0x2c).chr(0x44).chr(0x49).chr(0x52).chr(0x2c).chr(0x50).chr(0x2c).$j.chr(0x2c).chr(0x03); //Si pas trame 1 incrementer 12 en 12
					}
					else
					{
						$in = chr(0x00).chr(0x12).chr(0x01).chr(0x52).chr(0x2c).chr(0x50).chr(0x52).chr(0x47).chr(0x2c).chr(0x44).chr(0x49).chr(0x52).chr(0x2c).chr(0x50).chr(0x2c).$j.chr(0x2c).chr(0x03);
					}
					
					
					socket_write($socket, $in, strlen($in));
					
					$out = socket_read($socket, 3873);
					
		
					
					$out2 = socket_read($socket, 3873);
					

					
					for ($i = 4; $i <= strlen($out2); $i++) //Debut a 4 car 4 premier Quarter -) Taille trame
					{
						
						
						
						if(bin2hex($out2[$i]) == '0a') // Si en Hexa egale a (0a) saut de ligne (DETECTION FIN DE LIGNE)
						{
							$count++;
							$l++;
							$k = 0;
						
							
						}else{
							if($out2[$i] == '<' || $out2[$i] == '>') { // si ...Ne fais rien
								
							}else{
								if($out2[$i] == '|') {
									//echo ' ';
									
									$k++;
						
									
								}else{
									
									
									$tab[$l][$k]=$tab[$l][$k].$out2[$i];
									
								

								}
							}
						}

					}
					
					if($count == 11)
					{
						$count = 0;
					}
					else
					{

						$j = 2000;
					}
					
						$k =0; //Chaque fin de trame colone = 0 et ligne + 1
						$l++;
				}
				
				for	($i=0; $i<$l; $i++)
				{
					$tabnom[$z]=$tabnom[$z].$tab[$i][0]; //Recuperation des nom de fichier pour le telechargement de ceux-ci
					$z++;
				}
				
				for	($i=0; $i<$l; $i++)
				{
					$taille =$taille + $tab[$i][2]; 
				}
				
				$taille = $taille / 1000;
				
				socket_close ($socket) ;
			}

			
	



	
			
			
			
?>

<?php
	Start();
	Get_Dir();
?>







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
								DANOBAT TNC-10 
							</i> </b>
			</font>







			<BR>
			<BR>

			<div style="border: 2px solid black; margin-left: 30%; margin-right: 30%;">
			</br>
				<form enctype="multipart/form-data" action="Alt_send.php" method="POST" target="__URL__">
					File : <input name="file" id="file" type="file" required></input><br><BR>
					Nom : <input name="Nom" id="Nom" type="text" required></input></br><BR>
					Numero : <input name="Nbr" id="Nbr" type="text" minlength="6" maxlength="6" required></input><br><BR>
					
					
					<?php
						$ua=getBrowser();
						

						if ($ua['name'] == 'IE')
						{
							
							echo'<p style="color:#FF0000";>Internet explorer non compatible</p>';
							echo '<BR>';
						}
						else{
							echo'<input type="submit" value="Envoyer" name="send" id="send">';
						}

					?>
				</form>
			</div>
		</div>
		<button style="float: right;" onclick="window.location.href = 'danobat.php';">Retour</button>
	</center>
	<br />
  </div> 
</div>



<script type="text/javascript">

	var tab = <?php global $tabnom; echo json_encode($tabnom); ?>; //On récupère notre tableau des noms de fichier dans notre JS
	
	document.getElementById('file') //On sélectionne l'element avec l'ID "file"
		.addEventListener('change', function() { //Quand le fichier de cet element change 
		  
		var name = '';
		var fr=new FileReader(); //On créer un lecteur de fichier
		
		fr.readAsText(this.files[0]); //On lis le fichier en tant que texte

		fr.onload = function(){ 
			var contents = this.result; //On recupère le contenu du fichier
			
			var count = 0;
			for (let j = 1; j < contents.length; j++) { //On parcours le fichier
			  if (contents.substr(j, 1) != ',' && count === 0) { //Si le programme n'a toujours pas trouvé le character ";" et si la variable "count" est strictement égal à 0
				name += contents.substr(j, 1); //On continu de lire le fichier
			  }else{
				count++
			  }
			}
			
			document.getElementById("Nom").value = name; //On modifie l'élément avec l'ID "Nom" avec 
		}
	})

	document.getElementById('Nbr') //On sélectionne l'element avec l'ID "Nbr"
		.addEventListener('input', function() { //Quand on entre un character dans le champ
		
			var data = document.getElementById("Nbr").value; //On récupère la valeur du champ "Nbr"
			
			if(data.length != 6) //Si le nombre characters est strictement inférieur à 6
			{
				document.getElementById("Nbr").style.border = '3px solid red';
			}else{
				document.getElementById("Nbr").style.border = '3px solid green';
				
				var number = "P" + document.getElementById("Nbr").value; //On récupère le nom du fichier
				
				if(tab.find(element => element === number) === number) //Si le fichier existe déjà
				{
					document.getElementById("send").disabled = true; //On désactive le bouton
					alert("Fichier déjà existant");
				}else{
					document.getElementById("send").disabled = false; //On active le bouton
				}
			}
			
			
	})

</script>

</body>
</html>