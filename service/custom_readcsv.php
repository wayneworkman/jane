<?php


//Allowed characters within user data:
$symbols = array();
array_push($symbols,implode("",range('0', '9')));
array_push($symbols,implode("",range('a', 'z')));
array_push($symbols,implode("",range('A', 'Z')));
array_push($symbols,' ','-'); // Allow spaces and hyphens.

//Check for exitence of import file.
while (file_exists($PathToCSV)) {
	writeLog("Import file found at: '$PathToCSV'");


	//Check if the file is currently open or not.
	$isFileClosed = exec("lsof -- '$PathToCSV';echo $?");
	if ($isFileClosed != "1") {
		writeLog("Import file '$PathToCSV' is still open, delaying until next iteration.");
		break;
	}


	//Try to open the file.
	if (!$csv = fopen($PathToCSV,'r')) {
		writeLog(" Failed to open file '$PathToCSV'");
	} else {
		writeLog("Successfully opened file: '$PathToCSV' - begining import.");
	}


	//Begin reading the file line by line.
	while($csv_line = fgetcsv($csv)) {


		//This line defines what variables each field of data goes into, indicated by position - this is one row at a time.
		list($userImportedID, $NotSupportedAuth, $userUserName, $userPassword, $NotSupportedEmail, $userFirstName, $userLastName, $NotSupportedCity, $NotSupportedCountry, $NotSupportedLanguage, $NotSupportedInstitution, $NotSupportedDepartment, $userAction, $NotSupportedProfileFieldRelation, $userGroup, $NotSupportedProfileFieldHomeroom, $NotSupportedProfileFieldTeam, $NotSupportedProfileFieldGrade, $NotSupportedProfileFieldStatus) = $csv_line;

		$userAction = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userAction));
		$userFirstName = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userFirstName));
		$userMiddleName = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userMiddleName));
		$userLastName = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userLastName));
		$userGroup = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userGroup));
		$userUserName = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/i", "", $userUserName));


		//this check is how the header line is skipped. Can be replaced with different checks, meant to filter out header row.
		if ($userImportedID != "idnumber") {


			//Ensure every single username is unique.
			//If an abnormal username must be given, log it in the DB, and list abnormal usernames and IDs in the web UI.
			//The below file is what ensures unique usernames. 
			//You may comment this line to disable this functionality but doing so would risk duplicate usernames and errors.
			$isAbnormal="0"; //Initially set abnormal to false.
			include 'ensureUniqueUsernames.php';


			//Sql for inserting row of data into userDataToImport table.
			$sql="INSERT INTO userDataToImport (userAction,userFirstName,userMiddleName,userLastName,userGroup,userUserName,userPassword,userImportedID) VALUES ('$userAction','$userFirstName','$userMiddleName','$userLastName','$userGroup','$userUserName','$userPassword','$userImportedID')";

			//Insert the data.
			if ($link->query($sql)) {
				// good
			} else {
				// Error
				$link->close();
				writeLog("There was an error inserting data into the DB from the CSV file. SQL query was:");
				writeLog("$sql");
			}
		}
	}

        writeLog("Import from '$PathToCSV' is complete.");


	//Close the import file.
	if (!fclose($csv)) {
		writeLog("Can't close file '$PathToCSV'");
	} else {
		writeLog("Successfully closed file '$PathToCSV'");
	}


	// below lines sets aside old import files, can be commented out to not preserve import files.
	//if (!copy($PathToCSV, $PathToCSV . "." . date('Y-m-d'))) {
	//	writeLog("Can't copy file '$PathToCSV' to destination '$PathToCSV" . "." . date('Y-m-d') . "'";
	//} else {
	//	writeLog("Successfully copied '$PathToCSV' to destination '$PathToCSV" . "." . date('Y-m-d') ."'");
	//}
	


	//Delete the import file.
	if (!unlink($PathToCSV)) {
		writeLog("Can't delete file '$PathToCSV'");
	} else {
		writeLog("Import file '$PathToCSV' successfully deleted.");
	}
}
?>
