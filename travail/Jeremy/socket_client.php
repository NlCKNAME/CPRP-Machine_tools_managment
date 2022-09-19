<?php
$host="172.19.175.172"; 
    $port = 3873; // open a client connection 
    $fp = fsockopen ($host, $port, $errno, $errstr); 
    if (!$fp) 
	{ 
		$result = "Error: could not open socket connection"; 
    } 
	else
	{
		echo "Connexion réussie";		
	
	}
	
?> 




   
