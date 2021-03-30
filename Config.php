<?php
   header("Cache-Control: no-cache, must-revalidate");
   header("Expires: Mon, 01 Jan 2000 01:00:00 GMT");
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', 'Ganesh@123');
   define('DB_DATABASE', 'medicare');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE, 80);
   // if ($mysqli -> connect_errno) {
   //    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
   //   // exit();
   //  }

  
?>