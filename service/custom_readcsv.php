<?php


//Allowed characters within user data:
$symbols = array();
$symbols += range('a', 'z');
$symbols += range('A', 'Z');
$symbols += range('0', '9');
array_push($symbols,' ','-'); // Allow spaces and hyphens.


//Values that are not present in the import file should be loaded with a space.
$userMiddleName = " ";

while (file_exists($PathToCSV)) {
	$rightNow = new DateTime("@" . time());
	$rightNow->setTimezone(new DateTimeZone("$TimeZone"));
	echo $rightNow->format("F j, Y, g:i a") . " Import file found at: '$PathToCSV'\n";


	$isFileClosed = exec("lsof -- '$PathToCSV';echo $?");
	if ($isFileClosed != "1") {
		$rightNow = new DateTime("@" . time());
		$rightNow->setTimezone(new DateTimeZone("$TimeZone"));
		echo $rightNow->format("F j, Y, g:i a") . " Import file is still open, delaying until next iteration.\n";
		break;
	}


	$csv = fopen($PathToCSV,'r') or die(" Failed to open file '$PathToCSV'\n");
	$rightNow = new DateTime("@" . time());
	$rightNow->setTimezone(new DateTimeZone("$TimeZone"));
	echo $rightNow->format("F j, Y, g:i a") . " Successfully opened File: '$PathToCSV'\n";

	while($csv_line = fgetcsv($csv)) {
		list($userImportedID, $NotSupportedAuth, $userUserName, $userPassword, $NotSupportedEmail, $userFirstName, $userLastName, $NotSupportedCity, $NotSupportedCountry, $NotSupportedLanguage, $NotSupportedInstitution, $NotSupportedDepartment, $userAction, $NotSupportedProfileFieldRelation, $userGroup, $NotSupportedProfileFieldHomeroom, $NotSupportedProfileFieldTeam, $NotSupportedProfileFieldGrade, $NotSupportedProfileFieldStatus) = $csv_line;

		$userAction = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userAction));
		$userFirstName = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userFirstName));
		$userMiddleName = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userMiddleName));
		$userLastName = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userLastName));
		$userGroup = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userGroup));
		$userUserName = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userUserName));



		//Ensure every single username is unique.
		//If an abnormal username must be given, log it in the DB, and list abnormal usernames and IDs in the web UI for all to see.
                $isAbnormal="0"; //Initially set abnormal to false.
                //The below file is what ensures unique usernames. 
                //You may comment this line to disable this functionality but doing so would risk duplicate usernames and errors.
                include 'ensureUniqueUsernames.php';


		$sql="INSERT INTO userDataToImport (userAction,userFirstName,userMiddleName,userLastName,userGroup,userUserName,userPassword,userImportedID) VALUES ('$userAction','$userFirstName','$userMiddleName','$userLastName','$userGroup','$userUserName','$userPassword','$userImportedID')";
		if ($userAction != "idnumber") { //this check is how the header line is skipped. "Catagory" can be replaced with a word that always appears in the header.
			if ($link->query($sql)) {
				// good
			} else {
				// Error
				$link->close();
				die (" There was an error inserting data into the DB from the CSV file. SQL query was:\n\n$sql\n\n");
			}
		}
	}
	fclose($csv) or die(" Can't close file '$PathToCSV'\n");
	// below line sets aside old import files, can be commented out to not preserve incoming data.
	//copy($PathToCSV, $PathToCSV . "." . date('Y-m-d'));
	// below line deletes current import file.
	unlink($PathToCSV);
}
?>