<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<title>Transfert de fichier</title>
	<meta charset="iso-8859-1">
	<link rel="stylesheet" media="screen" type="text/css" title="Design" href="file/style-explorateur.css" />
	<script language="javascript" type="text/javascript" src="file/javascript.js"></script>
</head>

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
				echo "OK.\n";
			}
		}
		
		function Send(){
			global $socket, $result;
		
			$uploaddir = 'C:\wamp64\tmp';
			$uploadfile = $uploaddir . basename($_FILES['file']['name']);
		
			if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
				echo "File is valid, and was successfully uploaded.\n";
			} else {
				echo "Possible file upload attack!\n";
			}
			
			$name = $_FILES['file']['name'];
			$name2 = "C:\wamp64\tmp".$name;
			$file = fopen("C:\wamp64\\tmp".$name, "r");

			$Name = $_POST["Nom"];
			$Num = $_POST["Nbr"];
			$var = 0x1a;
			
			for($i = 0; $i < strlen($Name); $i++)
			{
				$var += 0x01;
			}
			
			for($j = 0; $j < 1; $j += 12)
			{
				//Send's Request Construction
				$in = chr(0x00).chr($var).chr(0x01).chr(0x53).chr(0x2c).chr(0x50).chr(0x52).chr(0x47).chr(0x2c).chr(0x54).chr(0x52).chr(0x4e).chr(0x2c).$Num.chr(0x2c).chr(0x2c).$Name.chr(0x2c).chr(0x4d).chr(0x58).chr(0x2d).chr(0x2d).chr(0x2c).chr(0x17);
				
				
				//Send's Data Request Construction
				$in2 = chr(0x00).chr(0xc2).chr(0x02);
				
				$lCount = 0;
				
				//We read all the file
				while (false !== ($char = fgetc($file))) 
				{
					//We add all charactere to the request
					if ($lCount > 0)
					{
						//If the character is 0x0d
						if(bin2hex($char) != '0d'){
							$in2 = $in2.$char;
						}
					}else{
						//If the character is 0x0a
						if(bin2hex($char) == '0a')
						{
							$lCount++;
						}
					}
					
				}
				
				$in2 = $in2.chr(0x03);
				
				//We send the transfert request 
				socket_write($socket, $in, strlen($in));
				
				//We get the answer of the machine
				$out = socket_read($socket, 3873);
				
				//We send the data to transfert
				socket_write($socket, $in2, strlen($in2));
				
				//We get the answer of the machine
				$out = socket_read($socket, 3873);
				$out = socket_read($socket, 3873);
			}
		}
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
					Connection to DANOBAT
				</i> </b>
			</font>
			
			<div style="border: 2px solid red; margin-left: 30%; margin-right: 30%;">
				<form action="Alt.php" method="POST" target="_self">
					Option : <input type="submit" name="N" value="0"> <input type="submit" name="N" value="1"> <input type="submit" name="N" value="2">
				</form>
			</div>
			<?php
				Start();
				Send();
			?>

		</center>
<br />

	
  </div> 
</div>

</body>
</html>