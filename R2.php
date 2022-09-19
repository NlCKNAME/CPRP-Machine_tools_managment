<?php
	$ID = $_GET['id'];
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($ID));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($ID));
    readfile($ID);
	exit;
?>
