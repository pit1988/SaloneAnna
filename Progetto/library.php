<?php

/***************************************/
/* FUNZIONI GENERALI PER PAGINE HTML   */
/***************************************/

/* Funzione per iniziare la pagina. In input il titolo */

function page_start($title) {
  echo<<<END
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="it" lang="it">
<head>
  <title>$title</title>
</head>

<body>
<hr />
<h2>$title</h2>
<hr />
END;
}

/* Funzione per terminare una pagina */

function page_end() {
  echo "
</body>
</html>";
};

/* funzione per il sottotitolo */

function subtitle($str) {
  echo "<h3>$str</h3>";
};

/* Funzione che ritorna un link, associato ad una URL. */

function hyperlink($str, $url) {
  return "<a href=\"$url\">$str</a>";
};

/***************************************/
/* FUNZIONI PER LA GESTIONE DI TABELLE */
/***************************************/

/* Funzione per iniziare una tabella html. In input l'array degli
   header delle colonne */
function table_start($row) {
  echo "<table border=\"1\">";
  echo "<tr>";
  foreach ($row as $field) 
    echo "<th>$field</th>";
  echo "</tr>";
};
  
/* funzione per stampare un array, come riga di tabella html */
function table_row($row) {
  echo "<tr>";
  foreach ($row as $field) 
    if ($field)
      echo "<td>$field</td>\n";
    else
      echo "<td>---</td>\n";
  echo "</tr>";
}

/* funzione per chiudere una tabella html */
function table_end() {
  echo "</table>";
};



/***************************************/
/* CONNESSIONE AL DATABASE             */
/***************************************/

/* Si connette e seleziona il database */

function dbConnect($dbname) {

  /* lab */
  $server="basidati";
  $username="login";
  $password="pwd";
  
  $conn=mysql_connect($server,$username,$password)
    or die("Impossibile connettersi!");

  mysql_select_db($dbname,$conn);

  return $conn;
}


/***************************************/
/* FUNZIONI PER AUTENTICAZIONE         */
/***************************************/

function new_user($login, $password) {

  /* si connette e seleziona il database da usare */
  $dbname="login-ES";
  $conn = dbConnect($dbname);

  /* preparazione dello statement */

  $query= sprintf("INSERT INTO Eser5Users VALUES (\"%s\", \"%s\")", 
		  $login, SHA1($password));
  
  /* Stampa la query a video ... utile per debug */
  /* echo "<B>Query</B>: $query <BR />"; */
  
  mysql_query($query,$conn)
    or die("Query fallita" . mysql_error($conn));
}


function get_pwd($login) {

  /* si connette e seleziona il database da usare */
  $dbname="login-ES";
  $conn = dbConnect($dbname);


  /* preparazione dello statement */
  $query= sprintf("SELECT * FROM Eser5Users WHERE Login=\"%s\"", 
		  $login);
  
  /* Stampa la query a video ... utile per debug */
  /* echo "<b>Query</b>: $query <br />"; */
  
  $result=mysql_query($query,$conn)
    or die("Query fallita" . mysql_error($conn));

  $output=mysql_fetch_assoc($result);

  if ($output)
    return $output['Password'];
  else 
    return FALSE;
}


/* inizia la sessione e verifica che l'utente sia autenticato */
function authenticate() {
  session_start();
  $login=$_SESSION['logged'];
  if (! $login) {
    return FALSE;
  } else {
    return $login;
  }
}


?>
