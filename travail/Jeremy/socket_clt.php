<?php
$host    = "172.19.175.172";
$port    = 3873;
$message = "Hello Server";
echo "Message To server :".$message;
// create socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("Could not create socket\n");
// connect to server
$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
// send string to server
socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
// get server response
$result = socket_read ($socket, 592) or die("Could not read server response\n");
echo "Reply From Server  :".$result;
// close socket
socket_close($socket);
?> 