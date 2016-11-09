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
		list($userAction, $userImportedID, $userFirstName, $userMiddleName, $userLastName, $userPassword, $userGroup) = $csv_line;

		//below line simply takes $userAction from csv file and strips all characters except those in $symbols out.
		//Same with many below lines.
		$userAction = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/", "", $userAction));
		$userFirstName = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/", "", $userFirstName));
		$userMiddleName = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/", "", $userMiddleName));
		$userLastName = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/", "", $userLastName));
		$userPassword = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/", "", $userPassword));
		$userGroup = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/", "", $userGroup));


		//Build username from first char in $userFirstName, 
		//first char in $userMiddleName, 
		//first char in $userLastName, 
		//and char 5 through 9 of the ID (last four of 9 digit ID, from char 5 going forward 4 chars).
		$userUserName = substr($userFirstName, 0, 1) . substr($userMiddleName,0,1) . substr($userLastName,0,1) . substr($userImportedID,5,4);

		//Make username all lowercase.
		$userUserName = strtolower($userUserName);



		//this check is how the header line is skipped. Can be replaced with different checks, meant to filter out header row.
		if ($userImportedID != "StudentID") {


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
	//	writeLog("Can't copy file '$PathToCSV' to destination '$PathToCSV" . "." . date('Y-m-d') . "'");
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
