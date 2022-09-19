<!DOCTYPE html>
<html lang="fr" dir="ltr">





<head>
	<title>Transfert de fichier</title>
	<meta charset="iso-8859-1">
	<link rel="stylesheet" media="screen" type="text/css" title="Design" href="file/style-explorateur.css" />
	
	<script language="javascript" type="text/javascript" src="file/javascript.js"></script>
	
	<script src="../../highcharts/code/highcharts.js"></script>
	<script src="../../highcharts/code/highcharts-more.js"></script>
	<script src="../../highcharts/code/modules/solid-gauge.js"></script>
	<script src="../../highcharts/code/modules/exporting.js"></script>
	<script src="../../highcharts/code/modules/export-data.js"></script>
	<script src="../../highcharts/code/modules/accessibility.js"></script>

	
	<style type="text/css">
.highcharts-figure .chart-container {
	width: 300px;
	height: 200px;
	float: left;
}

.highcharts-figure, .highcharts-data-table table {
	width: 600px;
	margin: 0 auto;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #EBEBEB;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}
.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

@media (max-width: 600px) {
	.highcharts-figure, .highcharts-data-table table {
		width: 100%;
	}
	.highcharts-figure .chart-container {
		width: 300px;
		float: none;
		margin: 0 auto;
	}

}


	</style>

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

	
	.Suppr {
	  transition-duration: 0.4s;
	  background-color: #FFFFFF;
	  border: 2px solid #BB0B0B;
	  font-size: 12px;
	  border-radius: 8px;
	  float: right;
	  margin-right : 10%;
	
	}

	.Suppr:hover {
	  background-color: #BB0B0B; 
	  color: white;
	}
	
	
	.outer-div {
     padding: 30px;
}
.inner-div {
     margin: 0 auto;
     width: 100px; 
}


</style>		
		
		
	
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
					
					echo '<div style="display: table;clear: both;">';
					
					$out2 = socket_read($socket, 3873);
					
					echo '<div style="text-align: left; float: center;width: 100%;">';
					
					for ($i = 4; $i <= strlen($out2); $i++) //Debut a 4 car 4 premier Quarter -) Taille trame
					{
						
						
						
						if(bin2hex($out2[$i]) == '0a') // Si en Hexa egale a (0a) saut de ligne (DETECTION FIN DE LIGNE)
						{
							$count++;
							$l++;
							$k=0;
						
							
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
				
				return $tab;
//				print_r ($tab) ;
				socket_close ($socket) ;
			}
			
			
	
		//----------------------------------------------------------------------		
		function Download($ID)
		{
				$name = $ID;
				$name = $name.".PIT";
				global $socket, $result;
				
				$myfile = fopen($name, "w");
				
				fwrite($myfile, '%');				
				
		
				

				
				$in = chr(0x00).chr(0x13).chr(0x01).chr(0x52).chr(0x2c).chr(0x50).chr(0x52).chr(0x47).chr(0x2c).chr(0x54).chr(0x52).chr(0x4e).chr(0x2c).$ID[1].$ID[2].$ID[3].$ID[4].$ID[5].$ID[6].$ID[7].chr(0x2c).chr(0x03);
				
				
				$NTab[$Tab_Nbl] = array();
				
				socket_write($socket, $in, strlen($in));
				
				$out = socket_read($socket, 3873);
				
				$CharCount = 0;
				
				for ($i = 0; $i <= strlen($out) - 1; $i++)
				{
					if($out[$i] == ',')
					{
						if($CharCount >= 5 && $CharCount < 7)
						{
							fwrite($myfile, $out[$i]);
							$CharCount++;
						}else{
							$CharCount++;
						}
					}else{
						if($CharCount >= 5 && $CharCount < 7)
						{
							fwrite($myfile, $out[$i]);
						}
					}
				}
				
				fwrite($myfile, "\n");
			
				
				
				$end = false;
				while($end == false)
				{
					$out2 = socket_read($socket, 3873);
					for($i = 3; $i < strlen($out2); $i++)
					{
						switch($out2[$i])
						{
							case "\x03":
								$end = true;
								break;
							case "\x0a":
								fwrite($myfile, $out2[$i]);
								break;
							case "\x17":
								break;
							default:
								fwrite($myfile, $out2[$i]);
								break;
						}
					}
					
				};
			
			fclose($myfile);
			
			header("Location: R2.php?id=$name");
			
			socket_close ($socket) ;

		}
		
		
		//----------------------------------------------------------------------	
		function suppr($ID)
		{
			global $socket, $result;
			
			$in = chr(0x00).chr(0x13).chr(0x01).chr(0x53).chr(0x2c).chr(0x50).chr(0x52).chr(0x47).chr(0x2c).chr(0x44).chr(0x45).chr(0x4c).chr(0x2c).$ID[1].$ID[2].$ID[3].$ID[4].$ID[5].$ID[6].$ID[7].chr(0x2c).chr(0x03);
			
			socket_write($socket, $in, strlen($in));
					
			$out = socket_read($socket, 3873);
			
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



 


		<BR>
		<center>
		<?php
			if(isset ($_GET['Download']))
			{
				Start();
				Download($_GET['Download']);	
			}
			elseif (isset ($_GET['Suppr']))
			{
				Start();
				Suppr($_GET['Suppr']);
				header("Location: danobat.php");

				
			}
			else
			{
				Start();
				$tabdef=Get_Dir();
				array_map('unlink', glob("C:\wamp64\www\*.PIT")); 
			}
		?>
		</center>
		<?php
		$size = sizeof($tabdef);		
		?>
		
	 <table>
		<tr>
		<td>
			<figure>
				<div id="container-speed" style=" width: 200px; height: 180px;"></div>
			</figure>
	<script type="text/javascript">
	var gaugeOptions = {
		chart: {
			type: 'solidgauge',
			backgroundColor: 'rgba(0,0,0,0)',
		},

		title: null,

		pane: {
			center: ['50%', '85%'],
			size: '100%',
			startAngle: -90,
			endAngle: 90,
			background: {
				backgroundColor:
					Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
				innerRadius: '60%',
				outerRadius: '100%',
				shape: 'arc'
			}
		},

		exporting: {
			enabled: false
		},

		tooltip: {
			enabled: false
		},

		// the value axis
		yAxis: {
			stops: [
				[0.1, '#55BF3B'], // green
				[0.5, '#DDDF0D'], // yellow
				[0.9, '#DF5353'] // red
			],
			lineWidth: 0,
			tickWidth: 0,
			minorTickInterval: null,
			tickAmount: 2,
			title: {
				y: -70
			},
			labels: {
				y: 16
			}
		},

		plotOptions: {
			solidgauge: {
				dataLabels: {
					y: 5,
					borderWidth: 0,
					useHTML: true
				}
			}
		}
	};

	// The speed gauge
	var chartSpeed = Highcharts.chart('container-speed', Highcharts.merge(gaugeOptions, {
		yAxis: {
			min: 0,
			max: 783.728,
			title: {
				text: 'Stockage'
			}
		},

		credits: {
			enabled: false
		},

		series: [{
			name: 'Speed',
			data: 
			<?php 
			

			global $taille;
			echo '[';
			echo $taille;
			echo ']';
			
			
			?>,
			dataLabels: {
				format:
					'<div style="text-align:center">' +
					'<span style="font-size:15px">{y}</span><br/>' +
					'<span style="font-size:8px;opacity:0.4">KBytes</span>' +
					'</div>'
			},
			tooltip: {
				valueSuffix: ' KBytes'
			}
		}]

	}));



	</script>
			</td>
			<td Align="center">
   

				<font face="arial" size="7" >
					<b> <i>
						DANOBAT TNC-10
					</i> </b>
				</font>
				<BR>
				<BR>
				<center>
			
					<button class="Envoi" onclick="window.location.href = 'index_send.php';">
					Envoi de fichier
					</button>
					
				</center>
				<BR>
			</td>
			
		
			
			</tr>
			
			
		</table>
		<BR>
		
		
		<button class="Suppr" onclick="masquer_div(' <?php echo($size) ; ?> ');">
				Activer la suppression
		</button>
		
	</div>
	
		
	
	<center>
		<BR> 
		


			<table cellpadding=4 cellspacing=2>
				<tr>	
					<th align="center">Identifiant</th>
					<th align="center">Nom</th>
					<th align="center">Taille</th>
					<th align="center">Date</th>
					<th align="center">Heure</th>
					<th align="center">Droit</th>
				</tr>
					
			
			<?php
				global $tabnom;
				for ($j=0;$j<sizeof($tabdef);$j++)
				{
					echo '<tr>';
					
						for($k=0;$k<6;$k++)
						{
							
							echo '<td align="center">';
							echo $tabdef[$j][$k];
							echo '</td>';
							
						}
						
					

						echo '<td> ';
						echo '<a href="?Download=';
						echo $tabnom[$j];
						echo '">';
						echo '<img title="Telecharger" src="img/download.png">';
						echo '<a>';
						echo '</td>';
						echo "\n" ;
						
						
						

						
						echo '<td>';
						echo '<div id="a_masquer';
						echo $j;
						echo'"  style="display:none;">';
						echo '<a href="?Suppr=';
						echo $tabnom[$j];
						echo '">';
						echo '<img title="Supprimer" src="img/delete.gif">';
						echo '</a>';
						echo '</div>';
						echo '</td>';
					
			
	
						echo '</tr>';
						
				}
				
				
			
	

				
			?>
		

			
	
			</table>
	</center>
	<BR>
	

</div>
</body>

	<script type="text/javascript">

		function masquer_div(size)
		{
			
		

			for (i = 0; i <= size; i++) {
				  if (document.getElementById("a_masquer"+i).style.display == 'none')
				  {
					   document.getElementById("a_masquer"+i).style.display = 'block';
				  }
				  else
				  {
					   document.getElementById("a_masquer"+i).style.display = 'none';
				  }
			}
		}
		
		</script>
</html>