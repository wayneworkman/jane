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
		//list($userAction, $userImportedID, $userFirstName, $userMiddleName, $userLastName, $userPassword, $userGroup) = $csv_line;
		list($userImportedID,$userDOB,$userFirstName,$userLastName,$schoolCode,$gradeLevel,$yearOfGraduation,$userAction,$enrollmentStatus,$currentWithdrawalDate,$currentYearSchoolEntryDate) = $csv_line;

		//below line simply takes $userAction from csv file and strips all characters except those in $symbols out.
		//Same with many below lines.
		$userImportedID = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/", "", $userImportedID));
		$userDOB = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/", "", $userDOB));
		$userFirstName = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/", "", $userFirstName));
		$userLastName = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/", "", $userLastName));
		$schoolCode = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/", "", $schoolCode));
		$gradeLevel = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/", "", $gradeLevel));
		$yearOfGraduation = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/", "", $yearOfGraduation));
		$userAction = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/", "", $userAction));
		$enrollmentStatus = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/", "", $enrollmentStatus));
		$currentWithdrawalDate = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/", "", $currentWithdrawalDate));
		$currentYearSchoolEntryDate = trim(preg_replace("/[^" . preg_quote(implode('',$symbols), '/') . "]/", "", $currentYearSchoolEntryDate));


		//Build username from studentID. 
		$userUserName = $userImportedID;

		//Make username all lowercase.
		$userUserName = strtolower($userUserName);

                //Make the password.
                $userPassword = $userDOB;

                //Make the user group, set it to schoolCode.
		$userGroup = $schoolCode;

                //We don't have a middle name in this example:
		$userMiddleName = '';


		//Check ID isn't empty.
		if (!isset($userImportedID) || trim($userImportedID)==='') {
			writeLog("User data did not have an ID, skipping.");
			continue;
		}

		//Check if action is empty.
                if (!isset($userAction) || trim($userAction)==='') {
                        writeLog("ID \"$userImportedID\" did not have an action in it's data, skipping.");
                        continue;
                }

		//Check if first name is empty.
		if (!isset($userFirstName) || trim($userFirstName)==='') {
			writeLog("ID \"$userImportedID\" did not have a first name in it's data, skipping.");
			continue;
		}

		//Check if last name is empty.
		if (!isset($userLastName) || trim($userLastName)==='') {
			writeLog("ID \"$userImportedID\" did not have a last name in it's data, skipping.");
			continue;
		}

		
		//Check if password is empty.
		if (!isset($userPassword) || trim($userPassword)==='') {
			writeLog("ID \"$userImportedID\" did not have a password in it's data, skipping.");
			continue;
		}

		//Check if group is empty.
		if (!isset($userGroup) || trim($userGroup)==='') {
			writeLog("ID \"$userImportedID\" did not have a group in it's data, skipping.");
			continue;
		}

		//Check that there are seven items in the line array.
		
		if (count($csv_line) < 7) {
			writeLog("ID \"$userImportedID\" did not have at least seven items in it's data, skipping.");
			continue;
		}


		//this check is how the header line is skipped. Can be replaced with different checks, meant to filter out header row.
		if ($userImportedID != "Student ID") {


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
