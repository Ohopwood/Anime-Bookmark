<?
session_start();
//check session first
if (!isset($_SESSION['email'])){
	echo "You are not logged in!";
	exit();
}else{

	include ("../includes/header.html");
?>

	<h2>Contact Us</h2>
		<h1>Email</h1>
			<form action="MAILTO:someone@example.com" method="post" enctype="text/plain">Name:<br>
			<input type="text" name="name" value="your name"><br>E-mail:<br>
			<input type="text" name="mail" value="your email"><br>Comment:<br>
			<input type="text" name="comment" value="your comment" size="50"><br><br>
			<input type="submit" value="Send">
			<input type="reset" value="Reset">
		</form>
		<h1>Call</h1>
			<p> 414-000-8766 </p>



<?
	include ("../includes/footer.html");
}
?>
