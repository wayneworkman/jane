<?php

// To use this file, after installation, replace 'readcsv.php' inside /jane/service/JaneEngine.php with this file's name.
// The line is towards the top.


//Allowed characters within user data:
$symbols = array();
$symbols += range('a', 'z');
$symbols += range('A', 'Z');
$symbols += range('0', '9');
array_push($symbols,' ','-',','); // Allow spaces and hyphens and commas in this example, because we perform data sterilizing on the csv line itself.



if (file_exists($PathToCSV)) {
	$csv = fopen($PathToCSV,'r') or die("can't open file");
	while($csv_line = fgetcsv($csv)) {

		
		//Clean entire line at once:
                $csv_line = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $csv_line));



		list($userImportedID, $NotSupportedAuth, $userUserName, $userPassword, $NotSupportedEmail, $userFirstName, $userLastName, $NotSupportedCity, $NotSupportedCountry, $NotSupportedLanguage, $NotSupportedInstitution, $NotSupportedDepartment, $userAction, $NotSupportedProfileFieldRelation, $userGroup, $NotSupportedProfileFieldHomeroom, $NotSupportedProfileFieldTeam, $NotSupportedProfileFieldGrade, $NotSupportedProfileFieldStatus) = $csv_line;



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
