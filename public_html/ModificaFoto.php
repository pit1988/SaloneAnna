<?php

require_once 'library.php';
include 'utils/DBlibrary.php';

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
    content_begin();
    $to_print='<form action="NuovaFoto.php" method="POST">
    <ul>
        <li>
            <p>
                <label for="img_desc">Descrizione</label>
                <input type="text" name="img_desc" id="img_desc" />
            </p>
            <p>
                <label for="uploadedfile">Inserisci un\'immagine</label>
                <input name="uploadedfile" type="file" id="uploadedfile" />
            </p>
            <p>
                <input class="btn btn-submit" type="submit" name="submit" value="Invia" tabindex="105"/>
                <span id="errors"></span>
            </p>
        </li>
    </ul>
</form>
    ';
    echo $to_print;
    if(isset($_POST["submit"]))
    {
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
    content_end();
    page_end();
}
?>

