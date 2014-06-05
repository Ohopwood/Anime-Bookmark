<?php
session_start();
//check session first
if (!isset($_SESSION['email'])){
	echo "You are not logged in!";
	exit();
}else{
	//include the header
	include ("../includes/header.html");
	require_once ('../../mysql_connect.php');
	$id=$_GET['id']; 
	$query = "DELETE FROM bookmark WHERE id=$id"; 
	$result = @mysql_query ($query);
	if ($result){
		echo "The selected record has been deleted."; 
	}else {
		echo "The selected record could not be deleted."; 
	}
	echo "<p><a href=index.php>Home</a>"; 
	mysql_close();
	//include the footer
	include ("../includes/footer.html");
}

?>
