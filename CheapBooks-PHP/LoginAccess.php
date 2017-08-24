<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors','On');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = $_POST["username"];
	$password = $_POST["password"];
	$encpass = md5($password);
	$_SESSION['username'] = $username;
}

try {
  $dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=cheapbooks","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  
  $dbh->beginTransaction();
  
  $stmt = $dbh->prepare("select password from Customer where username='$username'");
  $stmt->execute();
  $row = $stmt->fetch();
  $get_pwd = $row['password'];
  
  if ($encpass == $get_pwd) {
	  $_SESSION['basket'] = array();
	  header("Location: http://localhost/project2/page2.php");
      exit;	  
  }
  else {
	    echo "Username and password combination do not match! Please try again.";
		pagereload();
  }
  
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}
  function pagereload(){
	header("Location: http://localhost/project2/Login.html");
    exit;
}

?>

