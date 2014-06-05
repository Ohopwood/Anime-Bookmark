<?php
// Send NOTHING to the Web browser prior to the session_start() line!
// Check if the form has been submitted.
if (isset($_POST['submitted'])) {
	require_once ('../../mysql_connect.php'); // Connect to the db.
	$errors = array(); // Initialize error array.
	// Check for an email address.
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysql_real_escape_string(trim($_POST['email']));
	}
	// Check for a password.
	if (empty($_POST['password'])) {
		$errors[] = 'You forgot to enter your password.';
	} else {
		$p = mysql_real_escape_string($_POST['password']);
	}
	if (empty($errors)) { // If everything's OK.
		/* Retrieve the user_id and first_name for 
		that email/password combination. */
		$query = "SELECT * FROM users WHERE email='$e' AND pass='$p'"; 
		$result = @mysql_query ($query); // Run the query.
		$row = mysql_fetch_array ($result, MYSQL_NUM);
		if ($row) { // A record was pulled from the database.
			//Set the session data:
			session_start(); 
			$_SESSION['user_id'] = $row[0];
			$_SESSION['first_name'] = $row[1];
			$_SESSION['last_name'] = $row[2];
			$_SESSION['email'] = $row[3]; 
			
			// Redirect:
			header("Location:loggedin.php");
			exit(); // Quit the script.
		} else { // No record matched the query.
			$errors[] = 'The email address and password entered do not match those on file.'; // Public message.
		}
	} // End of if (empty($errors)) IF.
	mysql_close(); // Close the database connection.
} else { // Form has not been submitted.
	$errors = NULL;
} // End of the main Submit conditional.

// Begin the page now.
$page_title = 'Login';
include ('../includes/header.html');
if (!empty($errors)) { // Print any error messages.
	echo '<h1 id="mainhead">Error!</h1>
	<p class="error">The following error(s) occurred:<br />';
	foreach ($errors as $msg) { // Print each error.
		echo " - $msg<br />\n";
	}
	echo '</p><p>Please try again.</p>';
}

// Create the form.
?>

<h2>Please, login here.</h2>
<form action="login.php" method="post">
<p>Email Address: <input type="text" name="email" size="20" maxlength="40" /> </p>
<p>Password: <input type="password" name="password" size="20" maxlength="20" /></p>
<p><input type="submit" name="submit" value="Login" /></p>
<input type="hidden" name="submitted" value="TRUE" />
</form>
<center><img src="ninja.jpg" alt="Kakashi" title="Kakashi" height="400px" width="600px"/><br></center>

<?php
include ('../includes/footer.html');
?>
