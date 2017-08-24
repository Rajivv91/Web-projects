<?php
error_reporting(E_ALL);
ini_set('display_errors','On');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = $_POST["username"];
	$password = $_POST["password"];
	$email = $_POST["email"];
	$address = $_POST["address"];
	$phone = $_POST["phone"];
	$encpass = md5($password);

}

try {
  $dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=cheapbooks","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  
  $dbh->beginTransaction();

  $dbh->exec("insert into Customer values('$username','$address','$phone','$email','$encpass')")
        or die(print_r($dbh->errorInfo(), true));
  $dbh->commit();

} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}


 header("Location: http://localhost/project2/RegistrationSuccessful.html");
 exit;


?>


