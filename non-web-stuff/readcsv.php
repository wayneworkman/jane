<?php
include 'localVars.php';
include 'connect2db.php';

// $PathToCSV


$symbols = array();
$symbols += range('a', 'z');
$symbols += range('A', 'Z');
$symbols += range('0', '9');
array_push($symbols,' ','-');


$csv = fopen($PathToCSV,'r') or die("can't open file");
while($csv_line = fgetcsv($csv)) {
	list($userAction, $userImportedID, $userFirstName, $userMiddleName, $userLastName, $userPassword, $userGroup) = $csv_line;
	$userAction = preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userAction);
	
	// For some reason, this line throws out the entire string.
	//$userImportedID = preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userImportedID);
	
	
	$userFirstName = preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userFirstName);
	$userMiddleName = preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userMiddleName);
	$userLastName = preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userLastName);
	
	$userPassword = str_replace('/', '', $userPassword);
	
	// Below line not removing forward slashes.
	//$userPassword = preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userPassword);
	$userGroup = preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userGroup);

	
	$userUserName = substr($userFirstName, 0, 1) . substr($userMiddleName,0,1) . substr($userLastName,0,1) . substr($userImportedID,5,4);
	$userUserName = strtolower($userUserName);
	

	$sql="INSERT INTO userDataToImport (userAction,userFirstName,userMiddleName,userLastName,userGroup,userUserName,userPassword,userImportedID) VALUES ('$userAction','$userFirstName','$userMiddleName','$userLastName','$userGroup','$userUserName','$userPassword','$userImportedID')";


	if ($userAction != "Category") {
		if ($link->query($sql)) {
			// good
		} else {
			// Error
			$link->close();
			die ("There was an error inserting data into the DB from the CSV file.");
                }
	}
}
fclose($csv) or die("can't close file");


?>
