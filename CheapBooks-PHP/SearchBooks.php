<!DOCTYPE HTML>
<head><title>Page 2</title></head>
<body>

<?php
  session_start();
  if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/project2/Login.html");
    exit;
}
?>


<form action="Logout.php" method="post">
<input type="submit" value="Logout">
</form>

<br/><br/>

<form action="ProcessRequest.php" method="post">
Enter Author or Title: <input type="input" name = "search"> </br></br>
<input type="submit" name="byAuthor" value="Search by Author">
<input type="submit" name="byTitle" value="Search by Title">
</form>



<?php
 if (isset($_SESSION['search'])) {
	  $search = $_SESSION['search'];
	  
	  echo "<br/><br/>";
	  echo "<table>";
	  echo "<tr><th>Book</th><th>ISBN</th><th>Quantity</th></tr>";
	  
	  try {
		  $dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=cheapbooks","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		  
		  $dbh->beginTransaction();
		  
		  if ($_SESSION['byAuthor'] == 1)
			  $stmt = $dbh->prepare("select b.title, b.ISBN, sum(s.number) as quantity from book b, stocks s where b.ISBN = s.ISBN and b.ISBN in (select ISBN from author a, writtenby w where a.ssn = w.ssn and a.name = '$search')
group by s.ISBN having quantity > 0");
		  else
     		  $stmt = $dbh->prepare("select b.title, b.ISBN, sum(s.number) as quantity from book b, stocks s where b.ISBN = s.ISBN and b.title='$search' group by s.ISBN having quantity > 0");
		  
		  $stmt->execute();
		  
		  //$result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 

          foreach($stmt->fetchAll() as $row) { 
			echo "<tr>";
			echo "<form action='addToCart.php' method='post'>";
			echo "<td><input type='text' name ='bookname' value='$row[0]' readonly></td>";
			echo "<td><input type='text' name ='ISBN' value='$row[1]' readonly></td>";
			echo "<td><input type='text' name ='quantity' value='$row[2]' readonly></td>";
			echo "<td><input type='submit' value='Add to cart'></td>";
			echo "</form>";
			echo "</tr>";
		  }

		} catch (PDOException $e) {
		  print "Error!: " . $e->getMessage() . "<br/>";
		  die();
		} // end of catch block
 } // end of display search result condition	 
?>

<div id="ShoppingBasket">
<FORM METHOD="LINK" ACTION="page3.php">
<INPUT TYPE="submit" VALUE="Shopping Basket">
</FORM>

<p>Number of books in the cart:
  <?php
  if (isset($_SESSION['basket'])) {
	  $tot_quant = 0;
	  foreach($_SESSION['basket'] as $book => $quantity)
		$tot_quant = $tot_quant + $quantity;
	  echo $tot_quant;
  }
  else 
	  echo 0;
  ?>
  </p>
</div>
<br/><br/>

</body>
</html>