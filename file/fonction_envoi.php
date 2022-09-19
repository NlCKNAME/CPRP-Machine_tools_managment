<?php
if(isset($_POST['upload'])) // si le formulaire est soumis
{
    $repertoire = './'; // dossier où sera déplacé le fichier
    $tmp_file = $_FILES['fichier']['tmp_name'];	//-------------------------Demander à quoi correspond "tmp_name"

    if( !is_uploaded_file($tmp_file) )
    {
        exit("Le fichier est introuvable. <br>");
    }


    //Copie du fichier sur le serveur
    $nom_fichier = 'fichier_temp' . ".txt";
	$copie = move_uploaded_file($tmp_file, $repertoire . $nom_fichier);
    if(!$copie)
    {
        exit("Impossible de copier le fichier dans $repertoire. <br>");
    }

    echo "Le fichier a bien été uploadé. <br>";



	//Accéde à la création du socket
	if($copie)
	{
		header ('Location:socket_envoi.php');
	}
	else
	{
		echo "socket_envoi.php est inaccessible";
	}
}
echo "La variable upload est inaccessible";

?>
