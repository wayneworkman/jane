<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
	include 'connect2db.php';
	include 'functions.php';
	if ((isset($_REQUEST['Confirm'])) && (isset($_REQUEST['newUsername'])) && (isset($_REQUEST['oldUsername'])) && (isset($_REQUEST['trackingImportedID']))) {
		$Confirm = $link->real_escape_string(trim($_REQUEST['Confirm']));
		$newUsername = $link->real_escape_string(trim($_REQUEST['newUsername']));
		$oldUsername = $link->real_escape_string(trim($_REQUEST['oldUsername']));
		$trackingImportedID = $link->real_escape_string(trim($_REQUEST['trackingImportedID']));
	} else {
		$link->close();
		setMessage($incomplete,"usernameTracking.php");
	}

	if ($Confirm == "Confirmed") {

		$sql = "UPDATE `usernameTracking` SET `trackingUserName`='$newUsername',`trackingIsAbnormal`='1' WHERE `trackingImportedID` = '$trackingImportedID' AND `trackingUserName` = '$oldUsername'";
		if ($link->query($sql)) {
			// good, send back to usernameTracking.
			$NextURL="usernameTracking.php";
			header("Location: $NextURL");
		} else {
			// Error
			$link->close();
			setMessage($SiteErrorMessage,"usernameTracking.php");
		}
	} else {
		$link->close();
		setMessage($incomplete,"usernameTracking.php");
	}

}
?>
