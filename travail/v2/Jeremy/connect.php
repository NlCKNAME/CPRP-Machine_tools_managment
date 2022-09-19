<?php
//Connection SSL
$ftp = ftp_connect("172.19.174.177", 21) or exit('Erreur : connexion au serveur FTP impossible.');
if($ftp)
{
	echo "Connexion réussie";
}

//Identification
$login_result = ftp_login($ftp, "web", "webprojet4");

if($login_result)
{
	echo "Identification reussie !" ;
}
else
{
	echo "Identification nulle !" ;
}
	


if( isset($_POST['upload']) ) // si formulaire soumis
{
    //$content_dir = '/Franck/FTP/'; // dossier où sera déplacé le fichier
	
    $content_dir = './'; // dossier où sera déplacé le fichier

    $tmp_file = $_FILES['fichier']['tmp_name'];

	//echo $tmp_file ;
    if( !is_uploaded_file($tmp_file) )
    {
        exit("Le fichier est introuvable");
    }

    // on copie le fichier dans le dossier de destination
    $name_file = $_FILES['fichier']['name'];

    if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
    {
        exit("Impossible de copier le fichier dans $content_dir");
    }

    echo "Le fichier a bien été uploadé";
}


//Fermeture de la connection
ftp_close($ftp);
?>
