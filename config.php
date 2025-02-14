<?php
  $db_server = "localhost";
  $db_user = "root";
  $db_pass = "";
  $db_name = "voter";
  

  $conn = new mysqli($db_server, $db_user, $db_pass,$db_name);
  if($conn)
  {
  }
  else
  {
    echo"could not connect";
  }
  
?>







