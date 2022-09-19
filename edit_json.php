<?php
	$data = $_GET['json'];
    file_put_contents("./file.json", $data);
    header('Location: ./test_json.php');
?>
