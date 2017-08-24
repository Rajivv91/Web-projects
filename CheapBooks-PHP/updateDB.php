<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors','On');

$username = $_SESSION['username'];

try {
  $dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=cheapbooks","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  
  $dbh->beginTransaction();
  $dbh->exec("insert into shoppingbasket (username) values('$username')")
        or die(print_r($dbh->errorInfo(), true));
  $dbh->commit();
  
  
  $stmt = $dbh->prepare("select max(basketId) from shoppingbasket where username='$username'");
  $stmt->execute();
  $row = $stmt->fetch();
  $basketId = $row[0];
  echo "<h2>You have successfully placed order!</h2>"."<br/><br/>";
  
  foreach($_SESSION['basket'] as $book => $quantity) {
	  
		  $stmt = $dbh->prepare("select ISBN from book where title='$book'");
		  $stmt->execute();
		  $row = $stmt->fetch();
		  $ISBN = $row[0];

		  
		  $stmt = $dbh->prepare("select warehouseCode from stocks where ISBN='$ISBN'");
		  $stmt->execute();
		  $row = $stmt->fetch();
		  $warehouseCode = $row[0];
		  
		  $dbh->beginTransaction();
		  $dbh->exec("insert into contains values('$ISBN','$basketId','$quantity')")
          or die(print_r($dbh->errorInfo(), true));
          $dbh->commit();
		  
		  $dbh->beginTransaction();
		  $dbh->exec("UPDATE stocks SET number = number - '$quantity' where ISBN='$ISBN'")
          or die(print_r($dbh->errorInfo(), true));
          $dbh->commit();
		  
		  $dbh->beginTransaction();
		  $dbh->exec("insert into shippingorder (ISBN, warehouseCode, username, number) values('$ISBN','$warehouseCode','$username','$quantity')")
          or die(print_r($dbh->errorInfo(), true));
          $dbh->commit();

		  

		}

 
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}


?>