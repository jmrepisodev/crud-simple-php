
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname="crud_php_img";

try {
  //abrir una conexión
  $dsn="mysql:host=$servername;dbname=$dbname";
  $dbh = new PDO($dsn, $username, $password);
  // set the PDO error mode to exception
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "connected successfully";
 
} catch(PDOException $e) {
    echo $e->getMessage();
    //$errores[]= "connection failed: " . $e->getMessage();
}
?>