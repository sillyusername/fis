<!-- Checks to see if a user (admin) is logged in, if not page is redirected to login page -->
<?php 
   if ($_COOKIE['user'] == "Admin") 
      echo ""; 
       
   else { 
   header ( "Location: ../login.php" ); } 
?> 


<!-- Header of the webpage -->
<?php include '../childheader.php'; ?>


<!-- Link to the database -->
<?php include '../dbconnect.php'; ?>

<?php

echo "<center>";


// Title of the page 
echo "<h1>Habitat </h1>";

//if action is blank or the add button has been selected do the code with the semi-colons
if ($_POST['action'] == "" OR $_POST['action'] == "Add Habitat")
{

//Inserting information table
echo "

<form action='habitatgroup.php' method='post'>

<p>To add a new habitat, fill in the form and press the add habitat button.</p>

<table border='1'>
<tr>
  <td>Code</td>
  <td><input type='text' name='group_code' maxlength='4' value='" . $_POST['group_code'] . "'> </td>
 </tr>
<tr>
  <td>Name</td>
  <td><input type='text' name='group_name'value='" . $_POST['group_name'] . "'> </td>
 </tr>
</table>
<input type='submit' name='action' value='Add Habitat'> 
</form> 
<br>

";

//if the below data isn't entered then don't add the information to the database
if ($_POST['group_code'] != "" AND $_POST['group_name'] != "")
{
//if action is add do the code with the semi-colons
//$result is the insert SQL string used to add the data
if ($_POST['action'] == "Add Habitat")
{
	$result = "INSERT INTO habitatgroup  (group_code, group_name) VALUES('" . $_POST['group_code'] . "', '" . $_POST['group_name'] . "');"; 
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
echo "<br>";
//Prints to the screen that the record has been added
echo "<h1>Habitat Added</h1>";
echo "<br>";
mysqli_query($link,$result);
}
}




}
?>


<?php
//if action update or delete has been selected do the code with the semi-colons
if ($_POST['action'] == "Update Habitat" OR $_POST['action'] == "Delete Habitat" OR $_POST['action'] == "Select Habitat")
{
//if the below data isn't entered then don't don't update or delete the information to the database
if ($_POST['group_code'] != "" AND $_POST['group_name'] != "" )
{
//if action update has been selected update the database with the information entered
//$result is the insert SQL string used to update the data
if ($_POST['action'] == "Update Habitat")
{
	$result = "UPDATE habitatgroup SET group_name='" . $_POST['group_name'] . "' WHERE group_code='" . $_POST['group_code'] . "'"; 
	mysqli_query($link,$result);
}

//if action delete has been selected delete the selected record from the database
//$result is the insert SQL string used to delete the record
if ($_POST['action'] == "Delete Habitat")
{
	$result = "DELETE FROM habitatgroup WHERE group_code='" . $_POST['group_code'] . "'";
	mysqli_query($link,$result);
}
}
}

?>

<!-- The drop down box used to select a record to be updated or deleted -->
<form action='habitatgroup.php' method='post'>

<p>To edit or delete a habitat, select a habitat from the list and press the select habitat button.</p>

<table border='1'>
<tr>
  <td>Code</td>
  <td>
	<?php
	echo "<select id='group_code' name='group_code'>";
	$result = mysqli_query($link,"SELECT * FROM habitatgroup"); 
	while($row = mysqli_fetch_array($result)) {
		if($_POST['group_code'] == $row['group_code'])
		{
		echo "<option selected='selected' value='" . $row['group_code'] . "'>" . $row['group_code'] . " / " . $row['group_name'] . "</option>";
		}
		else
		{
		echo "<option value='" . $row['group_code'] . "'>" . $row['group_code'] . " / " . $row['group_name'] .   "</option>";
		}
	}
	echo "</select>";
	?>
</td>
<td>
<input type='submit' name='action' value='Select Habitat'> 
</td>
 </tr>
</table>
<input type='hidden' name='type' value='Edit'> 

</form> 
<br>



<?php
//if action back button has been selected, reload the web page
if ($_POST['action'] == 'Back to Add Habitat')
{
$_POST = array();
header('Location:habitatgroup.php'); 
}
?>




<?php




//if action update or delete or select record has been selected do the code with the semi-colons
if ($_POST['action'] == "Update Habitat" OR $_POST['action'] == "Delete Habitat" OR $_POST['action'] == "Select Habitat")
{

//if the below data isn't entered then don't display the messages
if ($_POST['group_code'] != "" AND $_POST['group_name'] != "" )
{
if ($_POST['action'] == "Update Habitat")
{
//Display the update messages
echo "<br>";
echo "<h1>Habitat Updated</h1>";
echo "<br>";
}

//Display the delete messages
if ($_POST['action'] == "Delete Habitat")
{
$result = "DELETE FROM habitatgroup WHERE group_code='" . $_POST['group_code'] . "'";
echo "<br>";
echo "<h1>Habitat Deleted</h1>";
echo "<br>";
}
}

$result = mysqli_query($link,"SELECT * FROM habitatgroup WHERE group_code='" . $_POST['group_code'] . "'");
$therow = mysqli_fetch_array($result);

// Table that display the information for the selected record
echo "
<form action='habitatgroup.php' method='post'>

<p>To edit or delete a habitat, change the data and press the update habitat button or to delete press the delete habitat button.</p>

<table border='1'>
<tr>
  <td>Code</td>
  <td><input type='text' readonly name='group_code'  maxlength='4' value='" . $therow['group_code'] . "'> </td>
 </tr>
<tr>
  <td>Name</td>
  <td><input type='text' name='group_name' value='" . $therow['group_name'] . "'> </td>
 </tr>
<tr>
</table>";
//the Update and Delete buttons
echo "
<input type='submit' name='action' value='Update Habitat' >
<input type='submit' name='action' value='Delete Habitat' >
</form> 

<br>";
//the back button
echo "
<a href='habitatgroup.php'><button>Back to Add Habitat </button></a>



<br>
";

}

?>

<br>
<!-- Back button -->
<form><input type='button' name='Back' value='Finished with Habitat' onClick="location.href='../samples.php'"></form>

</center>

<!-- Footer of the web page -->
<?php include '../childfooter.php'; ?>