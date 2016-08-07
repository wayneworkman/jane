<?php
/*
check if the user ID is already in the usernameTracking table. If it is, use the existing username.
If the ID doesn't exist, check if the given username is taken or not. If available, use it. If not, append a-z chars until it is.

*/

//Range of characters to append to suggested usernames that are already taken.
$alphas = range('a', 'z');


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
			echo "\nCould not update existing abnormal users userGroup in the usernameTracking table. Attempted SQL:\n\n$sql\n\n";
		}
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
				$sql = "INSERT INTO `usernameTracking` (`trackingImportedID`,`trackingUserName`,`trackingIsAbnormal`,`userGroup`) VALUES ('$userImportedID','$possibleUsername','$isAbnormal','$userGroup')";
				if ($link->query($sql)) {
					// good, return new username.
					$userUserName=$possibleUsername;
				} else {
					// Error
					echo "\nCould not store new user into usernameTracking table. Attempted SQL:\n\n$sql\n\n";
				}
			}
		}
		unset($value);

	} else {

		//Username is available. Store only necessary user information and exit.
		$sql = "INSERT INTO `usernameTracking` (`trackingImportedID`,`trackingUserName`,`trackingIsAbnormal`) VALUES ('$userImportedID','$userUserName','$isAbnormal')";
		if ($link->query($sql)) {
			// good
		} else {
			// Error
			echo "\nCould not store new user into usernameTracking table. Attempted SQL:\n\n$sql\n\n";
		}
	}
}
unset($alphas);
?>
