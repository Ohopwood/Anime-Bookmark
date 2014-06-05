<?php
session_start();
//check the session
if (!isset($_SESSION['email'])){
	echo "You are not logged in!";
	exit();
}else{
	//include the header
	include ("../includes/header.html");
	require_once ('../../mysql_connect.php');
	#execute UPDATE statement
	$id = mysql_real_escape_string($_POST['id']); 
	$title = mysql_real_escape_string($_POST['title']); 
	$url = mysql_real_escape_string($_POST['url']); 
	$comment = mysql_real_escape_string($_POST['comment']); 

	$query = "UPDATE bookmark SET title='$title',url='$url',comment='$comment' WHERE id='$id'"; 
	$result = @mysql_query($query); 
	if ($result){
		echo "<center><p><b>The selected record has been updated.</b></p>"; 
		echo "<a href=index.php>Home</a></center>"; 
	}else {
		echo "<p>The record could not be updated due to a system error" . mysql_error() . "</p>"; 
	}
	mysql_close();
	//include the footer
	include ("../includes/footer.html");
}

?>
