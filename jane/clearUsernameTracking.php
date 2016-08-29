<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
	include 'connect2db.php';
	include 'functions.php';
	if ($isAdministrator == 1) {

		if (isset($_REQUEST['ConfirmDelete'])) {
			$ConfirmDelete = $link->real_escape_string(trim($_REQUEST['ConfirmDelete']));
		}
		$years = $link->real_escape_string(trim($_REQUEST['years']));
		$thisMoment = time();

		if ((is_numeric($years)) && ($ConfirmDelete == "Confirmed")) {
			$timeDifference = ( $thisMoment - ($years * 31536000)); // 1 year in seconds is 31536000.

			$sql = "DELETE FROM `usernameTracking` WHERE `lastSeen` <= '$timeDifference'";
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
			setMessage($invalidData,"usernameTracking.php");
		}


	} else {
		//Not an admin, redirect to home.
		$NextURL="jane.php";
		header("Location: $NextURL");
	}
}
?>
