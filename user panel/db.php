<?php

$servername = "localhost";
$username   = "root";
$password   =  "";
$dbname     =  "db_hrmsoftwere";

   $conn = mysqli_connect($servername,$username,$password,$dbname);

   if($conn)
   {
    // echo"connection successful";
   }
   else
   {
    echo"connection failed";
   }

?>
<?php
$conn=mysqli_connect("localhost","root","","db_hrmsoftwere");
?>