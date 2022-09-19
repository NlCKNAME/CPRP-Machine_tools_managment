<?php
if(!($sock = socket_create(AF_INET, SOCK_STREAM, 0)))
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
     
    die("Impossible de créer le socket: [$errorcode] $errormsg \n");
}
 
echo "Socket créé \n";
 
if(!socket_connect($sock , '172.19.175.174' , 1470))
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
     
    die("Impossible de se connecter: [$errorcode] $errormsg \n");
}
 
echo "Connexion établie \n";


socket_close($sock);
?>