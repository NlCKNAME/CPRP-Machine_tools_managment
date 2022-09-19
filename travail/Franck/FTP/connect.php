<?php

if( isset($_POST['upload']) ) // si formulaire soumis
{
    $content_dir = './'; // dossier où sera déplacé le fichier

    $tmp_file = $_FILES['fichier']['tmp_name'];
    $name_file = $_FILES['fichier']['name'];

    if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
    {
        exit("Impossible de copier le fichier dans $content_dir");
    }

    echo "Le fichier a bien été uploadé";
}

?>

