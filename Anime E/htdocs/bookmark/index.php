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
	echo ("<center>"); 
	echo ("<h3>Bookmark</h3><p>");
	echo ("<a href=add.php>Add a record</a><p>"); 
	echo ("<a href=searchform.php>Search records</a><p>"); 
	//Set the number of records to display per page
	$display = 5;
	//Check if the number of required pages has been determined
	if(isset($_GET['p'])&&is_numeric($_GET['p'])){//Already been determined
		$pages = $_GET['p'];
	}else{//Need to determine
		//Count the number of records;
		$query = "SELECT COUNT(id) FROM bookmark";
		$result = @mysql_query($query); 
		$row = @mysql_fetch_array($result, MYSQL_NUM);
		$records = $row[0]; //get the number of records
		//Calculate the number of pages ...
		if($records > $display){//More than 1 page is needed
			$pages = ceil($records/$display);
		}else{
			$pages = 1;
		}
	}// End of p IF.

	//Determine where in the database to start returning results ...
	if(isset($_GET['s'])&&is_numeric($_GET['s'])){
		$start = $_GET['s'];
	}else{
		$start = 0;
	}

	//Make the paginated query;
	$query = "SELECT * FROM bookmark LIMIT $start, $display"; 
	$result = @mysql_query ($query);

	//Table header:
	echo "<table cellpadding=5 cellspacing=5 border=1><tr>
	<th>Title</th><th>Comment</th><th>URL</th><th>*</th><th>*</th></tr>"; 

	//Fetch and print all the records...
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		echo "<tr><td>".$row['title']."</td>"; 
		echo "<td>".$row['comment']."</td>"; 
		echo "<td><a href=".$row['url']." target=_blank>".$row['url']."</a></td>"; 
		echo "<td><a href=deleteconfirm.php?id=".$row['id'].">Delete</a></td>"; 
		echo "<td><a href=updateform.php?id=".$row['id'].">Update</a></td></tr>"; 
	} // End of While statement
	echo "</table>"; 
	mysql_free_result ($result); // Free up the resources.         
	mysql_close(); // Close the database connection.

	//Make the links to other pages if necessary.
	if($pages>1){
		echo '<br/><table><tr>';
		//Determine what page the script is on:
		$current_page = ($start/$display) + 1;
		//If it is not the first page, make a Previous button:
		if($current_page != 1){
			echo '<td><a href="index.php?s='. ($start - $display) . '&p=' . $pages. '"> Previous </a></td>';
		}
		//Make all the numbered pages:
		for($i = 1; $i <= $pages; $i++){
			if($i != $current_page){ // if not the current pages, generates links to that page
				echo '<td><a href="index.php?s='. (($display*($i-1))). '&p=' . $pages .'"> ' . $i . ' </a></td>';
			}else{ // if current page, print the page number
				echo '<td>'. $i. '</td>';
			}
		} //End of FOR loop
		//If it is not the last page, make a Next button:
		if($current_page != $pages){
			echo '<td><a href="index.php?s=' .($start + $display). '&p='. $pages. '"> Next </a></td>';
		}
		
		echo '</tr></table>';  //Close the table.
	}//End of pages links
	//include the footer
	include ("../includes/footer.html");
}
?>


