<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<title>Transfert de fichier</title>
	<meta charset="iso-8859-1">
	<link rel="stylesheet" media="screen" type="text/css" title="Design" href="file/style-explorateur.css" />
	<script language="javascript" type="text/javascript" src="file/javascript.js"></script>
</head>

<?php
	//header ('Content-Type: text/html; charset=windows-1252'); // permet d'afficher correctement avec l'utilisation de l'ASCII etendu (comme sur la machine)
	error_reporting(E_ALL);

	/* port du service. */
	$service_port = 19000 ;

	/* Adresse IP du serveur de destination */
	$address = "172.19.175.170" ;

	//------------------------------------------------------------------------
	//-----
	//------------------------------------------------------------------------
	function envoyer_et_afficher($donnees_a_transmettre,$la_socket)
	{
		//echo("<BR>\n") ;
		//echo "Envoi de la requete : ";
		//echo ($donnees_a_transmettre) ;
		socket_write($la_socket, $donnees_a_transmettre, strlen($donnees_a_transmettre));
		$out = socket_read($la_socket, 65535) ;
		//echo("<BR>\n") ;
		//echo "Réponse à la requete : ";
		//echo $out;
		//echo("<BR>\n") ;
		return $out ;		
	}

	//------------------------------------------------------------------------
	//-----
	//------------------------------------------------------------------------
	function envoyer_simple($donnees_a_transmettre,$la_socket)
	{
		socket_write($la_socket, $donnees_a_transmettre, strlen($donnees_a_transmettre));
	}

	//------------------------------------------------------------------------
	//-----
	//------------------------------------------------------------------------
	function envoyer_data($donnees_a_transmettre,$la_socket)
	{
		socket_write($la_socket, $donnees_a_transmettre, strlen($donnees_a_transmettre));
		$out = socket_read($la_socket, 65535);
		return $out ;		
	}

	//------------------------------------------------------------------------
	//-----
	//------------------------------------------------------------------------
	function lire_data($la_socket)
	{
		$out = socket_read($la_socket, 65535) ;
		return $out ;		
	}

	//------------------------------------------------------------------------
	//-----
	//------------------------------------------------------------------------
	function telecharger_fichier($name, $socket)
	{
		$myfile = fopen($name, "w");

		$data = "";

		$taille = strlen($_GET['dl']);
		$taille = $taille + 1;

		if($taille < 255)
		{
			$dat = dechex($taille);
			$in = "\x00\x00\x00";
			$in = $in.chr($taille);
		}

		$in = $in."R_FL".$name."\x00";
		$param = 0;

		$out = '';

		while($out != "\x00\x00\x00\x00T_FD" || $out != "\x00\x00\x00\x00T_ER")
		{
			envoyer_simple($in,$socket);
			$out = lire_data($socket);
			
			if($out == "\x00\x00\x00\x00T_FD" || $out == "\x00\x00\x00\x00T_ER")
			{
				$param = 10000000000;
				break;
			}

			$out = substr($out , (strlen($out ) - (strlen($out ) - 8) ) );

			$out = str_replace("\x00", "\n", $out);

			$data = $data.$out;

			$in = "\x00\x00\x00\x00T_OK" ;	// On répond OK car on a bien reçu

			$param++;
		}

		fwrite($myfile, $data);

		$in = "\x00\x00\x00\x00T_OK" ;	// On répond OK car on a bien reçu
		envoyer_simple($in,$socket) ; // $recup contient la réponse de la machine

		header("Location: ./r2_dmu.php?name=".$name);
		//return $data;
	}

	//------------------------------------------------------------------------
	//-----
	//------------------------------------------------------------------------
	function init_transfert_dmu($la_socket)
	{
		$in = "\x00\x00\x00\x08A_LGINSPECT\x00" ; // bascule en mode config machine ?
		envoyer_data($in,$la_socket) ;

		$in = "\x00\x00\x00\x00R_VR" ;
		$version_machine = envoyer_data($in,$la_socket) ;

		$in = "\x00\x00\x00\x00R_PR" ;
		envoyer_data($in,$la_socket) ;

		$in = "\x00\x00\x00\x02C_CC\x00\x03" ;
		envoyer_data($in,$la_socket) ;

		$in = "\x00\x00\x00\x02C_CC\x00\x06" ;
		envoyer_data($in,$la_socket) ;

		$in = "\x00\x00\x00\x02C_CC\x00\x13" ;
		envoyer_data($in,$la_socket) ;

		$in = "\x00\x00\x00\x05A_LGFILE\x00" ; // bascule en mode fichiers machine ?
		envoyer_data($in,$la_socket) ;

		$in = "\x00\x00\x00\x00R_ST" ;
		envoyer_data($in,$la_socket) ;

		$in = "\x00\x00\x00\x01R_VR\x05" ; // version soft ?
		envoyer_data($in,$la_socket) ;
	}

	//------------------------------------------------------------------------
	//-----
	//------------------------------------------------------------------------
	function lire_repertoire_courant($la_socket)
	{
		$in = "\x00\x00\x00\x00R_DI" ; // requète pour lire le répertoire courant
		$data = envoyer_data($in,$la_socket) ;
		$i=0 ;
		$repertoire = "" ;
		while($data[strlen($data)-2-$i] != "\x00")	// isole le répertoire
		 {
		 	$repertoire = $data[strlen($data)-2-$i].$repertoire ;
		 	$i++ ;
		 }
		return $repertoire ; 
	}


	function recup_arbo()
	{
		if(isset($_GET['tree'])) //Si le parametre "tree" est passe dans l'url
		{
			$receive = $_GET['tree']; //Reception de la variable "tree" passee dans l'url
			$arbo = array(); //Creation du tableau
			$value = ""; //Variable permettant la récupération des noms 

			for($i = 0; $i < strlen($receive); $i++) //Tant qu'il reste des donnees a traiter
			{
				
				if($receive[$i] == ',') //Si le character reçu est une virgule
				{
					array_push($arbo, $value); //On ajoute les données de value dans le tableau
					$value = ""; //On réinitialise la variable de récupération des noms
				}else{
					$value = $value.$receive[$i]; //On ajoute un character au nom
				}
			}
			array_push($arbo, $value); //On ajoute les données de value dans le tableau

			return $arbo; //Renvoi du tableau d'arbo
		}else{
			$arbo = array(); //Creation d'un tableau vide
			return $arbo; //Renvoi du tableau d'arbo
		}
		
		
	}


	//------------------------------------------------------------------------
	//-----
	//------------------------------------------------------------------------

	function naviguer_repertoire_uni($nom, $socket)
	{
		for($i = 1; $i < sizeof($nom); $i++)
		{
			$taille = strlen($nom[$i]);
			$taille = $taille + 1;

			if($taille < 255)
			{
				$dat = dechex($taille);
				$in2 = "\x00\x00\x00";
				$in2 = $in2.chr($taille);
			}

			$in2 = $in2."C_DC".$nom[$i]."\x00";
			if($i != sizeof($nom) - 1)
			{
				envoyer_et_afficher($in2,$socket);

				$repertoire_courant = lire_repertoire_courant($socket) ;

				$tab = lire_fichiers_dossiers($socket) ;

				$in = "\x00\x00\x00\x00R_ST" ;
				envoyer_et_afficher($in,$socket) ;

			}else{
				envoyer_et_afficher($in2,$socket);
				$repertoire_courant = lire_repertoire_courant($socket) ;
				echo ("repertoire courant : ".$repertoire_courant) ;
				echo("<BR>\n") ;

				$tab = lire_fichiers_dossiers($socket) ;
				affichage_repertoire($tab) ;

				$in = "\x00\x00\x00\x00R_ST" ;
				envoyer_et_afficher($in,$socket) ;
			}
		}
	}

	function naviguer_repertoire_uni_dl($nom, $socket)
	{
		for($i = 1; $i < sizeof($nom); $i++)
		{
			$taille = strlen($nom[$i]);
			$taille = $taille + 1;

			if($taille < 255)
			{
				$dat = dechex($taille);
				$in2 = "\x00\x00\x00";
				$in2 = $in2.chr($taille);
			}

			$in2 = $in2."C_DC".$nom[$i]."\x00";
			if($i != sizeof($nom) - 1)
			{
				envoyer_et_afficher($in2,$socket);

				$repertoire_courant = lire_repertoire_courant($socket) ;

				$tab = lire_fichiers_dossiers($socket) ;

				$in = "\x00\x00\x00\x00R_ST" ;
				envoyer_et_afficher($in,$socket) ;

			}else{
				envoyer_et_afficher($in2,$socket);
				$repertoire_courant = lire_repertoire_courant($socket);

				$tab = lire_fichiers_dossiers($socket);

				$in = "\x00\x00\x00\x00R_ST" ;
				envoyer_et_afficher($in,$socket) ;
			}
		}
	}

	//------------------------------------------------------------------------
	//---
	//--- 4 octets pour le nombre d'octet à suivre sans la réponse à l'ordre 
	//--- exemple, 0x00 0x00 0x07 0x08 S_DR : 4 octets --> 1800 + les 4 octets du type de réponse qui ne compte pas
	//--- même si on a reçu 1808 octets 4 octets tailles + 4 octets commande
	//--- la suite est formatté comme suit ;
	//--- 4 octets pour la taille, 
	//--- 4 octets pour la date en timestamp, 
	//--- 4 octets pour le type de fichier,
	//--- x octets pour texte à 0x00 terminal
	//---
	//--- retour dans un tableau
	//------------------------------------------------------------------------

	function lire_fichiers_dossiers($la_socket)
	{
		$tableau_contenu = array ();

		$in="\x00\x00\x00\x01R_DR\x01" ; // pour demander le répertoire
		$recup = envoyer_data($in,$la_socket) ; // $recup contient la réponse de la machine

		$taille_reception = ord($recup[0])*16777216 + ord($recup[1])*65536 + ord($recup[2])*256 + ord($recup[3])*1 ; // si on veut vérifier une bonne réception...
		//echo $taille_reception ; 	echo "<BR>\n" ;
		$reponse_commande = "" ;
		for ($i=4;$i<8;$i++) { $reponse_commande = $reponse_commande.$recup[$i] ;	}
		//echo $reponse_commande ; 	echo "<BR>\n" ;

		$date_fichier = new DateTime();
		$i = 8 ; // pointeur sur le premier fichier / dossier
		$nombre_de_fichiers = 0 ; // pour compter le nombre de fichiers dans le répertoire
		$nombre_de_dossiers = 0 ; // pour compter le nombre de dossiers dans le répertoire
		$indice_tableau = 0 ;
		while($i<strlen($recup))
		{
			$taille_fichier = ord($recup[$i+0])*16777216 
							+ ord($recup[$i+1])*65536 
							+ ord($recup[$i+2])*256 
							+ ord($recup[$i+3])*1 ;
			$timeStamp_fichier = ord($recup[$i+4])*16777216 
								+ ord($recup[$i+5])*65536 
								+ ord($recup[$i+6])*256 
								+ ord($recup[$i+7])*1 ;
			$date_fichier->setTimestamp($timeStamp_fichier); // on formate le TimeStamp en DateTime
			$type_de_fichier = ord($recup[$i+11]) ; // 
			$marqueur = "" ; 
			if (($type_de_fichier & 0x01) == 0x01) { $marqueur = $marqueur."E" ; }
			if (($type_de_fichier & 0x02) == 0x02) { $marqueur = $marqueur."M" ; }
			if (($type_de_fichier & 0x04) == 0x04) { $marqueur = $marqueur."S" ; }
			if (($type_de_fichier & 0x08) == 0x08) { $type_hide = true ; } 
			else { $type_hide = false ; }
			if (($type_de_fichier & 0x40) == 0x40) { $type_dossier = true ; } 
			else { $type_dossier = false ; }
			
			$nom_du_fichier = "" ;
			$i = $i + 12 ; // pointe sur la première lettre du fichier, texte à 0x00 terminal
			while(ord($recup[$i]) != 0x00)
			{
				$nom_du_fichier = $nom_du_fichier.$recup[$i] ;
				$i++ ;
			}
			$i++ ; // pour passer le 0x00 terminal du texte

			if ($type_hide == false ) // si fichier/dossier non caché alors on compte
			{
				if ($type_dossier == true) 
					{ 
						$nombre_de_dossiers++ ; 
						array_push ($tableau_contenu,[
							"nom" 		=> $nom_du_fichier,
							"taille" 	=> 0,
							"attributs"	=> 0,
							"type"		=> "DIR",
							"date"		=> $date_fichier ]) ;
					}
				else
					{ 
						$nombre_de_fichiers++ ;
						array_push ($tableau_contenu,[
							"nom" 		=> $nom_du_fichier,
							"taille" 	=> $taille_fichier,
							"attributs"	=> $marqueur,
							"type"		=> "",
							"date"		=> $date_fichier ]) ;
					}
			}
		}
		
		$in = "\x00\x00\x00\x00T_OK" ;	// On répond OK car on a bien reçu
		//envoyer_et_afficher($in,$socket) ; // on affiche aussi la réponse
		envoyer_data($in,$la_socket) ; // juste envoyer la reponse sans afficher

		// echo("nombre de dossiers : ".$nombre_de_dossiers) ; echo("<BR>\n") ;
		// echo("nombre de fichiers : ".$nombre_de_fichiers) ; echo("<BR>\n") ;
		// print_r($tableau_contenu);
		return ($tableau_contenu) ;
	}

	//------------------------------------------------------------------------
	//-----  
	//------------------------------------------------------------------------
	function affichage_repertoire($tableau_a_afficher) 
	{
		//print_r($tableau_a_afficher);
		echo ("<table style=\"width: 60%; \">\n") ;
		echo ("<tr>\n") ;
		echo ("	<th>nom</th> 
				<th>taille</th> 
				<th>attributs</th> 
				<th>type</th> 
				<th>date</th> 
				<th>action</th> \n") ;
		echo ("</tr>\n") ;

		for ($i = 0; $i < sizeof($tableau_a_afficher); $i++ )
		{
			if ($tableau_a_afficher[$i]["type"]=="DIR")
			{
				if($tableau_a_afficher[$i]["nom"] == "..") //Vérifie si le dossier est le dossier "Retour arrière"
				{
					$name = $tableau_a_afficher[$i]["nom"];
					echo ("<tr>\n") ;
					echo ("<td><dutexte style=\"color: #0000ff; font-weight: bold; \" onclick=\"back()\" >".$tableau_a_afficher[$i]["nom"]."</dutexte></td>") ;
					echo ("<td>".""."</td>") ;
					echo ("<td>".""."</td>") ;
					echo ("<td>".$tableau_a_afficher[$i]["type"]."</td>") ;
					echo ("<td>".""."</td>") ;
					//echo ("<td>".$tableau_a_afficher[$i]["date"]."</td>") ;
				}else{
					if($tableau_a_afficher[$i]["nom"] != "tncguide" && $tableau_a_afficher[$i]["nom"] != "mdna" && $tableau_a_afficher[$i]["nom"] != "SOFTWARE" && $tableau_a_afficher[$i]["nom"] != "System Volume Information") //Vérifie si le dossier ne fait pas partie des dossiers à cacher
					{
						$name = $tableau_a_afficher[$i]["nom"];
						echo ("<tr>\n") ;
						echo ("<td><dutexte style=\"color: #0000ff; font-weight: bold; \" onclick=\"test('".$name."')\" >".$tableau_a_afficher[$i]["nom"]."</dutexte></td>") ;
						echo ("<td>".""."</td>") ;
						echo ("<td>".""."</td>") ;
						echo ("<td>".$tableau_a_afficher[$i]["type"]."</td>") ;
						echo ("<td>".""."</td>") ;
						//echo ("<td>".$tableau_a_afficher[$i]["date"]."</td>") ;	
					}
				}
			}
			else
			{
				if((substr($tableau_a_afficher[$i]["nom"], -1) == "I" || substr($tableau_a_afficher[$i]["nom"], -1) == "H" || substr($tableau_a_afficher[$i]["nom"], -1) == "T" || substr($tableau_a_afficher[$i]["nom"], -3) == "TCH") && substr($tableau_a_afficher[$i]["nom"], -3) != "CDT") //Vérifie si le dossier ne fait pas partie des dossiers à cacher
				{
					echo ("<tr style=\"color: #000000;\" >\n") ;
					if(isset($_GET['dl']))
					{
						echo ("<td><dutexte onclick=\"Download('".$tableau_a_afficher[$i]["nom"]."', '".$_GET['name']."')\" >".$tableau_a_afficher[$i]["nom"]."</dutexte></td>") ;
					}else{
						echo ("<td><dutexte onclick=\"Download('".$tableau_a_afficher[$i]["nom"]."', 0)\" >".$tableau_a_afficher[$i]["nom"]."</dutexte></td>") ;
					}
					echo ("<td>".$tableau_a_afficher[$i]["taille"]."</td>") ;
					echo ("<td>".$tableau_a_afficher[$i]["attributs"]."</td>") ;
					echo ("<td>".$tableau_a_afficher[$i]["type"]."</td>") ;
					//echo ("<td>".$tableau_a_afficher[$i]["date"]."</td>") ;
					echo ("<td>".""."</td>") ;
					/*if(isset($_GET['dl']))
					{
						echo ('<td><img onclick="Download(\''.$tableau_a_afficher[$i]["nom"]."\', \'".$_GET['name'].'\')" title="Telecharger" src="img/download.png"></td>');
					}else{
						echo ('<td><img onclick="Download(\''.$tableau_a_afficher[$i]["nom"]."\', \'".$_GET['name'].'\', 0)" title="Telecharger" src="img/download.png"></td>');
					}*/
				}

			}
						 
			echo ("</tr>\n") ;
		}
		echo ("</table>\n") ;
	}

	//------------------------------------------------------------------------
	//----- Crée un socket TCP/IP. 
	//------------------------------------------------------------------------
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
					DMU 40
				</i> </b>
</font>







<BR>
<BR>

			<div style="border: 2px solid black; margin-left: 30%; margin-right: 30%;">
			</br>
				<form enctype="multipart/form-data" <?php echo 'action="Alt_send_dmu.php?tree='.$_GET['tree'].'"'; ?> method="POST" target="__URL__">
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

</body>
</html>