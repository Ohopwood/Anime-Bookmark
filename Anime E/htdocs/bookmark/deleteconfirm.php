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
	$query = "SELECT * FROM bookmark WHERE id=$id"; 
	$result = @mysql_query ($query);
	$num = mysql_num_rows($result);
	if ($num > 0) { // If it ran OK, display all the records.
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			echo $row['url']."<br>".$row['title']."<p>"; 
		} // End of While statement
		echo "Are you sure that you want to delete this record?<br>";
		echo "<a href=delete.php?id=".$id.">YES</a> 
			<a href=index.php>NO</a>"; 
		mysql_free_result ($result); // Free up the resources.         
	}else{ // If it did not run OK.
		echo '<p>There is no such record.</p>';
	}
	mysql_close(); // Close the database connection.
	//include the footer
		include ("../includes/footer.html");
}

?>
