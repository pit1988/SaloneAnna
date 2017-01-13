<body background="sfondo.jpg">
  <p align="right" valign="top">/Home/Appuntamenti/Toptype</p>
  <!-- Site navigation menu -->
  <table>
    <tr>
      <td>
        <ul class="navbar">
          <li><a href="Root.php">Home page</a></li>
          <li><a href="Clienti.php">Clienti</a></li>
          <li><a href="Prodotti.php">Prodotti</a></li>
          <li><a href="Appuntamenti.php">Appuntamenti</a></li>
        </ul>
      </td>
      <td>
        <?php
          include ("dbconnect.php");
          $conn=dbconnect();
          
          $query = "
          SELECT (p.Parziali/COUNT(*))*100 AS Percentuale, TipoAppuntamento
          FROM Contatori p NATURAL JOIN AppuntamentiClienti
          GROUP BY TipoAppuntamento;
          
          ";
          $result = mysqli_query($conn, $query);
          
          
          $number_cols = mysqli_num_fields($result);
          
          echo "<b>Classifica appuntamenti per tipo:</b>";
          echo "<table border = 1>\n";
          echo "<tr align=center>\n";
          for($i=0; $i<$number_cols; $i++)
            {
              echo "<th>" . mysqli_field_seek ($result, $i). "</th>\n";
            }
          echo "</tr>\n";
          
          //intestazione tabella
          
          //corpo tabella
          while ($row = mysqli_fetch_row($result))
          {
            echo "<tr align=left>\n";
          
            for ($i=0; $i<$number_cols; $i++)
            {
              echo "<td>";
              if(!isset($row[$i]))
                {echo "NULL";}
              else
                {echo $row[$i];}
              echo "</td>\n";
            }
            echo "</td>\n";
          }
          
          echo "</table>";
          
          ?>
      </td>
    </tr>
  </table>
</body>