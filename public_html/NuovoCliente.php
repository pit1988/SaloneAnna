
<?php

session_start();
session_regenerate_id(TRUE);

// Controllo accesso
if (!isset($_SESSION['username'] ) )
{
	header('location:index.php');
	exit;
}
else
{
/*	if(!isset($_POST['submit']) || !isset($_POST['first_name']) || !isset($_POST['last_name']) || !isset($_POST['email']) || !isset($_POST['phone']) || !isset($_POST['data'])){
		$err= "Uno dei parametri non è stato inserito correttamente";

		  $nome = $_POST['nome'];
  $cognome= $_POST['cognome'];
  $email = $_POST['email'];
  $telefono = $_POST['telefono'];
  $data=*/

	}
	require 'library.php';
	$title="Clienti: Salone Anna";
	$title_meta="Clienti: Salone Anna";
	$descr="";
	$keywords="Clienti, Parrucchiere, Montecchio, Vicenza, Taglio, Colorazioni, Donna";
	
	page_start($title, $title_meta, $descr, $keywords,'');
	$rif='<a href="index.php" xml:lang="en">Home</a> / <strong>Clienti</strong>';
	insert_header($rif, 2, true);
	content_begin();
				echo '<h2>Nuovo Cliente</h2>

<form action="NuovoCliente.php" onsubmit="return true;" method="post">
                <ul>
                    <li>
                        <p>
                            <label for="first_name">Nome</label>
                            <input type="text" name="first_name" id="first_name" tabindex="100"/>
                        </p>
                        <p>
                            <label for="last_name">Cognome</label>
                            <input type="text" name="last_name" id="last_name" tabindex="101" />
                        </p>
                    </li>
                    <li xml:lang="en">
                        <p>
                            <label for="email">E-Mail</label>
                            <input type="text" name="email" id="email" tabindex="102" />
                        </p>
                    </li>
                    <li>
                        <label for="phone">Telefono</label>
                         <input type="text" name="phone" id="phone" tabindex="103" />
                    </li>
                    <li>
                        <label for="data">Data di nascita</label>
                        <input type="text" name="data" id="data" tabindex="104"
                    <li xml:lang="en">
                        <input class="btn btn-submit" type="submit" value="Invia" tabindex="105"/>
                        <input type="reset" value="cancella"
                        <span id="errors"></span>
                    </li>
                    <li>
                        <div class="divider"></div>
                    </li>
                </ul>
            </form>
';
		content_end();
    page_end();
		}
?>
			