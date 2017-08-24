<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors','On');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$book = $_POST['bookname'];
	if (array_key_exists($book,$_SESSION['basket']))
		$_SESSION['basket'][$book] += 1;
	else
		$_SESSION['basket'][$book] = 1;
}

header("Location: http://localhost/project2/page2.php");
die;

?>