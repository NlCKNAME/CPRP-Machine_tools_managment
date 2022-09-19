<?php
	$name = $_GET['name'];
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($name));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($name));
    readfile($name);
    exit;
?>