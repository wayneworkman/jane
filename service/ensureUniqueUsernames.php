<?php
/*
check if the user ID is already in the usernameTracking table. If it is, use the existing username.
If the ID doesn't exist, check if the given username is taken or not. If available, use it. If not, append a-z chars until it is.

*/

//Range of characters to append to suggested usernames that are already taken.
$alphas = range('1', '9');
$lastSeen = time();


//See if user's ID exists or not yet.
$sql = "SELECT `trackingUserName`, `trackingIsAbnormal` FROM `usernameTracking` WHERE `trackingImportedID`='$userImportedID' LIMIT 1";
$resultTracking1 = $link->query($sql);
if ($resultTracking1->num_rows > 0) {
 
	//user is already established, reuse existing username, update userGroup only if abnormal, and exit.
	while($rowTracking1 = $resultTracking1->fetch_assoc()) {
		$userUserName = trim($rowTracking1["trackingUserName"]);
		$isAbnormal = trim($rowTracking1["trackingIsAbnormal"]);
	}
	unset($rowTracking1);
	unset($resultTracking1);

	//if abnormal, update usergroup.
	if ($isAbnormal == "1") {
		$sql = "UPDATE `usernameTracking` SET `userGroup` = '$userGroup' WHERE `trackingImportedID`='$userImportedID'";
		if ($link->query($sql)) {
			// good
		} else {
			// Error
			writeLog("Could not update existing abnormal users userGroup in the usernameTracking table for ID '$userImportedID'. Attempted SQL:");
			writeLog("$sql");
		}
	}


	//Update last seen.
	$sql = "UPDATE `usernameTracking` SET `lastSeen` = '$lastSeen' WHERE `trackingImportedID`='$userImportedID'";
	if ($link->query($sql)) {
		// good
	} else {
		// Error
		writeLog("Could not update lastSeen field in usernameTracking table for pre-existing ID '$userImportedID'. Attempted SQL:");
		writeLog("$sql");
	}

} else {

	//user is not established. Check if the suggested username is available or not.
	$sql = "SELECT `trackingID` FROM `usernameTracking` WHERE `trackingUserName`='$userUserName'";
	$resultTracking2 = $link->query($sql);
	if ($resultTracking2->num_rows > 0) {

		//Username is taken. Append chars a-z until a free username is found.
		$isAbnormal="1"; //Mark as abnormal.
		foreach ($alphas as &$charToAppend) {
			$possibleUsername=$userUserName . $charToAppend;
			$sql = "SELECT `trackingID` FROM `usernameTracking` WHERE `trackingUserName`='$possibleUsername' LIMIT 1";
			$resultTracking3 = $link->query($sql);
			if ($resultTracking3->num_rows == 0) { //Note:  num_rows == 0 to check for no rows returned.
				//Abnormal username is available. Store it and exit.
				$sql = "INSERT INTO `usernameTracking` (`trackingImportedID`,`trackingUserName`,`trackingIsAbnormal`,`abnormalReason`,`userGroup`,`lastSeen`) VALUES ('$userImportedID','$possibleUsername','$isAbnormal','During initial import \"$userUserName\" was already taken; so \"$possibleUsername\" was assigned.','$userGroup','$lastSeen')";
				if ($link->query($sql)) {
					// good, return new username.
					$userUserName=$possibleUsername;
					break;
				} else {
					// Error
					writeLog("Could not store new user into usernameTracking table for abnormal username with ID '$userImportedID'. Attempted SQL:");
					writeLog("$sql");
				}
			}
		}
		unset($value);

	} else {

		//Username is available. Store only necessary user information and exit.
		$sql = "INSERT INTO `usernameTracking` (`trackingImportedID`,`trackingUserName`,`trackingIsAbnormal`,`lastSeen`) VALUES ('$userImportedID','$userUserName','$isAbnormal','$lastSeen')";
		if ($link->query($sql)) {
			// good
		} else {
			// Error
			writeLog("Could not store new user into usernameTracking table for ID '$userImportedID'. Attempted SQL:");
			writeLog("$sql");
		}
	}
}
unset($alphas);
?>
