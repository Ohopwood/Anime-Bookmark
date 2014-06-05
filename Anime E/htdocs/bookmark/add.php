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
	if ($_POST['submitted']){
		$title=$_POST['title']; 
		$comment=$_POST['comment']; 
		$url=$_POST['url']; 
		$query="INSERT INTO bookmark (title, comment, url)
			Values ('$title', '$comment', '$url')"; 
		$result=@mysql_query($query); 
		if ($result){
			echo "<center><p><b>A new URL has been added.</b></p>"; 
			echo "<a href=index.php>Show All URLs</a></center>"; 
		}else {
			echo "<p>The record could not be added due to a system error" . mysql_error() . "</p>"; 
		}
	} // only if submitted by the form
	mysql_close();
?>
	<form action="<? echo $PHP_SELF;?>" method="post">
	Title: <input name="title" size=50><p>
	URL: <input name="url" size=50><p>
	Comment: <br>
	<textarea name="comment" rows=5 cols=100></textarea>
	<p>
	<input type=submit value=submit>
	<input type=reset value=reset>
	<input type=hidden name=submitted value=true>
	</form>
<?
	//include the footer
	include ("../includes/footer.html");
}
?>



