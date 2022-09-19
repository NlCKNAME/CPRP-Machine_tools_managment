<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<title>Transfert de fichier</title>
	<meta charset="iso-8859-1">
	<link rel="stylesheet" media="screen" type="text/css" title="Design" href="file/style-explorateur.css" />
	<script language="javascript" type="text/javascript" src="file/javascript.js"></script>
</head>

	<style>

	.Envoi {
	  transition-duration: 0.4s;
	  background-color: #FFFFFF;
	  border: 2px solid #4CAF50; /* Green */
	  font-size: 18px;
	  border-radius: 8px;
	}

	.Envoi:hover {
	  background-color: #4CAF50; /* Green */
	  color: white;
	}




</style>	

<?php
		function Start(){
			$service_port = 3873;
			
			$address = gethostbyname('172.19.175.172');

			global $socket;
			
			$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			
			global $result;
			
			$result = socket_connect($socket, $address, $service_port);
			if ($socket === false) {
				echo "socket_connect() a échoué : raison : ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
			} else {
				
			}
		}
		
		function Send()
		{
			global $socket, $result;
			global $tabnom;
		
		
			$uploaddir = 'C:\wamp64\tmp';
			$uploadfile = $uploaddir . basename($_FILES['file']['name']);
		
			if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
				echo '<BR>';
				echo "<h1 style=\"color : green\">Fichier transféré avec succés</h1>\n";
				echo '<BR>';
				echo '<BR>';
			} else {
				echo "Possible file upload attack!\n";
			}
			
			$name = $_FILES['file']['name'];
			$name2 = "C:\wamp64\\tmp".$name;
			$file = fopen("C:\wamp64\\tmp".$name, "r");

			$Name = $_POST["Nom"]; //Commentaire
			$Num = $_POST["Nbr"]; //Num prog
			
			
			//---------------------------------------------------------------
			
			
			$var = 0x1a;
			
			for($i = 0; $i < strlen($Name); $i++)
			{
				$var += 0x01;
			}
			
			//Send's Request Construction (OK)
			$in = chr(0x00).chr($var).chr(0x01).chr(0x53).chr(0x2c).chr(0x50).chr(0x52).chr(0x47).chr(0x2c).chr(0x54).chr(0x52).chr(0x4e).chr(0x2c).$Num.chr(0x2c).chr(0x2c).$Name.chr(0x2c).chr(0x4d).chr(0x58).chr(0x2d).chr(0x2d).chr(0x2c).chr(0x17);
			
			socket_write($socket, $in, strlen($in));

			$array = "";
			$array2 = "";
			$data = "";
	

			$s = 0;
			
			while(false !== ($char = fgetc($file))) {
				$array = $array.$char;
			}

			$size = strlen($array);
			
			
			for ($i=0; $i < $size; $i++)
			{
				if (bin2hex($array[$i]) != '0d')
				{
					$array2 = $array2.$array[$i];
				}
				
				
			}
			
			$i = 0;
			
			$L = false;
			
			while($L == false) 
			{
				if (bin2hex($array[$i]) == '0a')
				{
					$L = true;
				}
				
				$i++;
				
			}
			 
			 
			$size = strlen($array2);
			
			///////////////////////////////////Avant ok conversion vers tab deux sans 0d
			
			
			$s = ($i - 1);
			$size = $size - ($i - 1);
			$i =0;
			
			while ($size > 1)
			{
				
				if ($size >= 1000)
				{
					for($i = 1; $i <= 1000; $i++)
					{
						$data=$data.$array2[$s];
						$s++;
						$size --;
					}
					
					while(bin2hex($array2[$s]) != '0a')
					{
						$data = $data.$array2[$s];
						$s ++;
						$size --;
						$i++;
					}
					$data = $data.$array2[$s];
					$s++;
					$size --;
					$i++;
				}
				else
				{
					
					
					
					$cpt = $size;
					for($i = 1; $i <= $cpt; $i++)
					{
						$data=$data.$array2[$s];
						$s++;
						$size --;
					}

					
				}
				
				//calcul taille trame
				$i = $i+1;
				$t = dechex($i);
				$t = str_pad($t, 4, "0", STR_PAD_LEFT );
				//exemple : $t = "00f4"  chr(00) et chr (f4)
				$in = chr(hexdec(substr($t,0,2))).chr(hexdec(substr($t,2,2))).chr(0x02); // formatage de la taille pour envoyer correctement
				
				if ($i >= 1000)
				{
					
					$send = $in.$data.chr(0x17);
					socket_write($socket, $send, strlen($send));
					
				
					$data = "";
					$send = "";
					time_nanosleep(0, 500000000) ; // 0.5 secondes
					
				}
				else
				{
					
					$send = $in.$data.chr(0x03);
					socket_write($socket, $send, strlen($send));
					

					$data = "";
					$send = "";
					$out = socket_read($socket, 3873);
					time_nanosleep(0, 500000000) ; // 0.5 secondes
					
					
					
				}
				
				
				
				$i = 0;
			
				
				
				
				
				
			}
			
			
			socket_close($socket);	
			
		}
		
		
		//-----------------------------------------------------------------------------------------

			
			
		//----------------------------------------------------------------------		
			
		
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
					DANOBAT TNC-10 
				</i> </b>
			</font>
			<div style="margin-left: 30%; margin-right: 30%;">
				
			</div>
			<?php
				Start();
				Send();
			?>
			
			<button class="Envoi" onclick="window.location.href = 'danobat.php';">
			Retour
			</button>

			
			
</center>
<br />

	
  </div> 
</div>

</body>
</html>