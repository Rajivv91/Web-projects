<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors','On');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST['search']))
		$_SESSION['search'] = NULL;
	else 
		$_SESSION['search'] = $_POST['search'];
	
	if (isset($_POST['byAuthor'])) {
        $_SESSION['byAuthor'] = 1;
		$_SESSION['byTitle'] = NULL;
    } else {
        $_SESSION['byAuthor'] = NULL;
		$_SESSION['byTitle'] = 1;
    }

}

header("Location: http://localhost/project2/page2.php");
die;
?>