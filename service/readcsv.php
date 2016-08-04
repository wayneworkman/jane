<?php


//Allowed characters within user data:
$symbols = array();
$symbols += range('a', 'z');
$symbols += range('A', 'Z');
$symbols += range('0', '9');
array_push($symbols,' ','-'); // Allow spaces and hyphens.


if (file_exists($PathToCSV)) {
	$csv = fopen($PathToCSV,'r') or die("can't open file");
	while($csv_line = fgetcsv($csv)) {
		list($userAction, $userImportedID, $userFirstName, $userMiddleName, $userLastName, $userPassword, $userGroup) = $csv_line;
		$userAction = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userAction));
		$userFirstName = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userFirstName));
		$userMiddleName = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userMiddleName));
		$userLastName = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userLastName));

		$userPassword = trim(str_replace('/', '', $userPassword));
		$userGroup = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userGroup));


		$userUserName = substr($userFirstName, 0, 1) . substr($userMiddleName,0,1) . substr($userLastName,0,1) . substr($userImportedID,5,4);
		$userUserName = strtolower($userUserName);









		//Ensure every single username is unique.
		//If an abnormal username must be given, log it in the DB, and list abnormal usernames and IDs in the web UI for all to see.
                $isAbnormal="0"; //Initially set abnormal to false.
                include 'ensureUniqueUsernames.php';


		$sql="INSERT INTO userDataToImport (userAction,userFirstName,userMiddleName,userLastName,userGroup,userUserName,userPassword,userImportedID) VALUES ('$userAction','$userFirstName','$userMiddleName','$userLastName','$userGroup','$userUserName','$userPassword','$userImportedID')";
		if ($userAction != "Category") { //this check is how the header line is skipped. "Catagory" can be replaced with a word that always appears in the header.
			if ($link->query($sql)) {
				// good
			} else {
				// Error
				$link->close();
				die ("There was an error inserting data into the DB from the CSV file. SQL query was:\n\n$sql\n\n");
			}
		}
	}
	fclose($csv) or die("can't close file");
	// below line sets aside old import files, can be commented out to not preserve incoming data.
	//copy($PathToCSV, $PathToCSV . "." . date('Y-m-d'));
	// below line deletes current import file.
	unlink($PathToCSV);
}
?>
