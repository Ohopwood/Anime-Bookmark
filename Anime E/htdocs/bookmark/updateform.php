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
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
?>
			<form action="update.php" method="post">
			Title: <input name="title" size=50 value="<? echo $row['title']; ?>"><p>
			URL: <input name="url" size=50 value="<? echo $row['url']; ?>"><p>
			Comment: <br>
			<textarea name="comment" rows=5 cols=100><? echo $row['comment'];?></textarea>
			<p>
			<input type=submit value=update>
			<input type=reset value=reset>
			<input type=hidden name="id" value="<? echo $row['id']; ?>">
			</form>
<?
		} //end while statement
	} //end if statement
	mysql_close();
	//include the footer
	include ("../includes/footer.html");
}
?>





