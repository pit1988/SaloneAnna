<?php
  include("DBlibrary.php");
  $conn = dbconnect();
  $submit=$_POST["submit"];
  $quantita=$_POST["quantita"];
  $prod=$_POST["prod"];
  $i=$_POST["i"];
  
  
  if (isset($submit))
  {
  if(isset($prod)){
  foreach $prod echo"$prod";
  
  mysqli_query($conn, $query) or 
      die (mysqli_error());
  msqli_close($conn);
  }
  ?>
  
<b>Inserimento avvenuto con successo</b><br>

<?php echo "<i>Vuoi inserire un appuntamento per $name $surname?</i>"
  ?>

<form action="./NuovoAppuntamento.php" target="_blank">
  <input type="submit"value="Si">
</form>

<?php
  }
  else
  {
      include("GestProd.php");
  }
  ?>