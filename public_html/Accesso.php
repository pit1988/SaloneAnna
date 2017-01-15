<?php
require 'library.php';
$title="Salone Anna: tariffe, orari, indirizzo";
$title_meta="Salone Anna, parrucchiere a Vicenza";
$descr="Pagina principale del Salone Anna, parrucchiere a Montecchio, propone tecniche di taglio, colorazioni e trattamenti per Uomo e Donna";
$keywords="Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna ";

page_start($title, $title_meta, $descr, $keywords);
$rif="Ti trovi in: <strong xml:lang=&quot;en&quot;>Home</strong>";
insert_header($rif, 0);
echo<<<END
	<form name="login" action="Login.php" method="POST">
		<p><i>Username</i></p>
		<p><input type="text" name="username" value=""></p>
		<p><i>Password</i></p>
		<p><input type="password" name="password" value=""></p>
		<p><input type="submit" value="Login..."></p>
	</form>
END;
page_end();
?>

	