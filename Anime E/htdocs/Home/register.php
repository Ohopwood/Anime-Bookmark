<?php 
// Include header.php
include("../includes/header.html");
// Check if the form has been submitted.
if (isset($_POST['submitted'])) {
	require_once ('../../mysql_connect.php'); // Connect to the db.
	$errors = array(); // Initialize error array.

	// Check for a first name.
	if (empty($_POST['first_name'])) {
		$errors[] = 'You forgot to enter your first name.';
	} else {
		$first_name = mysql_real_escape_string($_POST['first_name']);
	}

	// Check for a last name.
	if (empty($_POST['last_name'])) {
		$errors[] = 'You forgot to enter your last name.';
	} else {
		$last_name = mysql_real_escape_string($_POST['last_name']);
	}

	// Check for an email address.
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$email = mysql_real_escape_string($_POST['email']);
	}

	// Check for a password and match against the confirmed password.
	if (!empty($_POST['password1']) && !empty($_POST['password2'])) {
		if ($_POST['password1'] != $_POST['password2']) {
			$errors[] = 'Your password did not match the confirmed password.';
		} else {
			$password = mysql_real_escape_string($_POST['password1']);
		}
	} else {
		$errors[] = 'You forgot to enter your password.';
	}

	if (empty($errors)) { // If everything's OK.
		// Register the user in the database.
		// Check for previous registration.
		$query = "SELECT user_id FROM users WHERE email='$email'";
		$result = mysql_query($query);
		if (mysqli_num_rows($result) == 0) { // if there is no such email address
			// Make the query.
			$query = "INSERT INTO users (first_name, last_name, email, pass, registration_date) 
			VALUES ('$first_name', '$last_name', '$email', '$password', NOW() )";		
			$result = @mysqli_query ($query); // Run the query.
			if ($result) { // If it ran OK.
				echo "<p>You are now registered. Please, login to use our great service.</p>";
				echo "<a href=login.php>Login</a>";
				exit();
			} else { // If it did not run OK.
				$errors[] = 'You could not be registered due to a system error. We apologize for any inconvenience.'; // Public message.
				$errors[] = mysql_error(); // MySQL error message.
			}

		} else { // Email address is already taken.
			$errors[] = 'The email address has already been registered.';
		}

	} // End of if (empty($errors)) IF.

	mysql_close(); // Close the database connection.

} else { // Form has not been submitted.
	$errors = NULL;
} // End of the main Submit conditional.

// Begin the page now.
if (!empty($errors)) { // Print any error messages.
	echo '<h1>Error!</h1>
	<p>The following error(s) occurred:<br />';
	foreach ($errors as $msg) { // Print each error.
		echo "$msg<br />";
	}
	echo '</p>';
	echo '<p>Please try again.</p>';
}

// Create the form.
?>

<h2>New Account</h2>
<form action="register.php" method="post">
	<p>First Name: <input type="text" name="first_name" size="15" maxlength="15" 
	                value="<?php echo $_POST['first_name']; ?>" /></p>
	<p>Last Name: <input type="text" name="last_name" size="15" maxlength="30" 
					value="<?php echo $_POST['last_name']; ?>" /></p>
	<p>Email Address: <input type="text" name="email" size="20" maxlength="40" 
					value="<?php echo $_POST['email']; ?>"  /> </p>
	<p>Password: <input type="password" name="password1" size="10" maxlength="20" /></p>
	<p>Confirm Password: <input type="password" name="password2" size="10" maxlength="20" /></p>
	<p><input type="submit" name="submit" value="Register" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
</form>
<img src="Anime.jpg" alt="Anime Mix" title="Anime Mix" height="400px" width="600px"/>
<?php
// Include footer.php
include("../includes/footer.html");
?>
