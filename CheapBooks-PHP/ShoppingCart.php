<!DOCTYPE HTML>
<head><title>Page 3</title></head>
<body>

<?php
  session_start();
?>

  <?php

	  
	  echo "<table>
      <tr><th>Book Name</th><th>Quantity</th></tr>";
	  
	  foreach($_SESSION['basket'] as $book => $quantity) {
		echo "<tr>";
		echo "<td>".htmlspecialchars($book)."</td>";
		echo "<td>".htmlspecialchars($quantity)."</td>";
		echo "<tr>"; 
	  }
	  
	  echo "<p>Total Price of the cart is: $";

	  $tot_price = 0.0;
	  try {
		$dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=cheapbooks","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	  
		$dbh->beginTransaction();
		foreach($_SESSION['basket'] as $book => $quantity) {
		  $stmt = $dbh->prepare("select price from book where title='$book'");
		  $stmt->execute();
		  $row = $stmt->fetch();
		  $price = $row[0];
		  $tot_price = $tot_price + ($price * $quantity);
		}
	  } catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	  }
	  echo $tot_price;

	  echo "</p>";
	  echo "<div>";
	  echo "<form action='buy.php' method='post'>";
	  echo "<input type='submit' value='Buy'>";
	  echo "</form>";
	  echo "<br/>";
	  echo "</div>";
  

  ?>
</body>
</html>
