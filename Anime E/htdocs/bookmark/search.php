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
	echo ("<html><title>Search Results</title><center>"); 
	echo ("<a href=searchform.php>Another Search</a><p>"); 
	echo ("<a href=index.php>Home</a><p>"); 
	//formulate the search query
	if (!empty($_POST['id'])||!empty($_POST['title'])||!empty($_POST['url'])
		||!empty($_POST['comment'])){
		$id = mysql_real_escape_string($_POST['id']); 
		$title = mysql_real_escape_string($_POST['title']); 
		$url = mysql_real_escape_string($_POST['url']); 
		$comment = mysql_real_escape_string($_POST['comment']); 
		
		$query="SELECT * FROM bookmark WHERE (title LIKE '%$title%')
		AND (url LIKE '%$url%')
		AND (comment LIKE '%$comment%')";
	}else {
		$query="SELECT * FROM bookmark";
	}
	$result = @mysql_query ($query);
	$num = mysql_num_rows($result);
	if ($num > 0) { // If it ran OK, display all the records.
		echo "<p><b>Your search returns $num entries.</b></p>";
		echo "<table cellpadding=5 cellspacing=5 border=1><tr>
		<th>Title</th><th>Comment</th><th>URL</th><th>*</th><th>*</th></tr>"; 
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			echo "<tr><td>".$row['title']."</td>"; 
			echo "<td>".$row['comment']."</td>"; 
			echo "<td><a href=".$row['url']." target=_blank>".$row['url']."</a></td>"; 
			echo "<td><a href=deleteconfirm.php?id=".$row['id'].">Delete</a></td>"; 
			echo "<td><a href=updateform.php?id=".$row['id'].">Update</a></td></tr>"; 
		} // End of While statement
		echo "</table>"; 
		mysql_free_result ($result); // Free up the resources.         
	} else { // If it did not run OK.
		echo '<p>Your search hits no result.</p>';
	}
	mysql_close(); // Close the database connection.
	echo ("</center></html>"); 
	//include the footer
	include ("../includes/footer.html");
}

?>