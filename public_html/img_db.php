<?php

require_once 'library.php';
include 'utils/dbconnect.php';

session_start();
session_regenerate_id(TRUE);

// Controllo accesso
if (!isset($_SESSION['username'] ) )
{
    header('location:index.php');
    exit;
}
else{
    $title="Salone Anna: Inserisci foto";
    $title_meta="Salone Anna, parrucchiere a Vicenza";
    $descr="Pagina per inserire fotografie all'interno del sito";
    $keywords="Fotografie, Immagini, Foto, Anna, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna ";
    page_start($title, $title_meta, $descr, $keywords, '');
    $rif="Ti trovi in: <strong xml:lang=&quot;en&quot;>Home</strong>";
    $is_admin=true;
    insert_header($rif, 1, $is_admin);
    $to_print='<form enctype="multipart/form-data" action="img_db.php" method="POST">
    Image Title: <input type="text" name="img_title" /><br /><br />
    Image Description: <input type="text" name="img_desc" /><br /><br />
    Choose a file to upload: <input name="uploadedfile" type="file" /><br /><br />
    <input name="submit" type="submit" value="submit" />
    ';
    echo $to_print;
    if(isset($_POST["submit"]))
    {
        $img_title=$_POST["img_title"];
        $img_desc=$_POST["img_desc"];
        $img_name=$_FILES["uploadedfile"]["name"];
        if (($_FILES["uploadedfile"]["type"]=="image/gif"
             || $_FILES["uploadedfile"]["type"]=="image/jpeg"
             || $_FILES["uploadedfile"]["type"]=="image/pjpeg"
             && $_FILES["uploadedfile"]["size"]<20000))
        {
            if ($_FILES["uploadedfile"]["error"]>0)
            {
                echo "Return Code:".$_FILES["uploadedfile"]["error"]."<br />";
            }
            else
            {
                $conn = dbconnect();
                $i=1;
                $success=false;
                $new_img_name=$img_name;
                while(!$success)
                {
                    if (file_exists("uploads/".$new_img_name))
                    {
                        $i++;
                        $new_img_name="$i".$img_name;
                    }
                    else
                    {
                        $success=true;
                    }
                }
                move_uploaded_file($_FILES["uploadedfile"]["tmp_name"],"uploads/".$new_img_name);
                echo "Stored in: "."uploads/".$new_img_name;
                echo "<br />";
                $qry="INSERT INTO Images(Img_title,Img_desc,Img_filename)
                    VALUES('$img_title','$img_desc','$new_img_name')";
                if(! mysqli_query($conn, $qry))
                {
                    die("An error".mysql_error());
                }
                else
                {
                    echo "1 row added";
                }
            }
        }
        else
        {
            echo "Invalid file";
        }
    }
    
    if(isset($err))
        echo"<p><b>Errore: $err</b></p>";
    page_end();
}
?>