<?php
require 'library.php';
include 'utils/dbconnect.php';
/* se l'utente non si è gia` autenticato, va alla pagina da cui fare il login*/
session_start();
session_regenerate_id(TRUE);

$title="Foto Salone Anna";
$title_meta="Foto Salone Anna, parrucchiere a Vicenza";
$descr="Fotografie di clienti del Salone Anna";
$keywords="Foto, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
page_start($title, $title_meta, $descr, $keywords);
$rif='Ti trovi in: <a href="index.html" xml:lang="en">Home</a> / <strong>Foto</strong>';
$is_admin=false;
$name="visitatore";

if (isset($_SESSION['username'] ) ) {
    $is_admin=true;
    content_begin();
    $name = $_SESSION['username'];
}

insert_header($rif, 0, $is_admin);
content_begin();


	// collegarsi al DB, leggere le immagini ed inserirle.
	$conn=dbconnect();
	$qry="SELECT * FROM Images";
	$result=mysqli_query($conn, $qry);
	echo "<h1>Image Gallery</h1>";
	echo "<dl id=\"foto\">";

	while($row=mysqli_fetch_array($result)) {
	    echo "<dd><figure>.<img	src=uploads/".$row['Img_filename']."><figcaption>" . $row['Img_title'] . "</figcaption></figure></dd>";
	}

	echo "</dl>";


	
content_end();
page_end();
?>