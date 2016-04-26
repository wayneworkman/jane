<?php


//Allowed characters within user data:
$symbols = array();
$symbols += range('a', 'z');
$symbols += range('A', 'Z');
$symbols += range('0', '9');
array_push($symbols,' ','-');


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
	// below line sets aside old import files, and is temporary.
	copy($PathToCSV, $PathToCSV . "." . date('Y-m-d'));
	// below line deletes current import file.
	unlink($PathToCSV);
}
?>
