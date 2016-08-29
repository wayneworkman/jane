<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
	include 'connect2db.php';
	if ($isAdministrator == 1) {

		if (isset($_REQUEST['ConfirmDelete'])) {
			$ConfirmDelete = $link->real_escape_string(trim($_REQUEST['ConfirmDelete']));
		}
		$days = $link->real_escape_string(trim($_REQUEST['days']));
		$thisMoment = time();

		if ((is_numeric($days)) && ($ConfirmDelete == "Confirmed")) {
			$timeDifference = ( $thisMoment - ($days * 86400)); // 1 day in seconds is 86400.

			$sql = "DELETE FROM `Sessions` WHERE `REQUEST_TIME` <= '$timeDifference'";
			if ($link->query($sql)) {
				// good, send back to usernameTracking.
				$NextURL="showSessions.php";
				header("Location: $NextURL");
			} else {
				// Error
				$link->close();
				die ($SiteErrorMessage);
			}
		} else {
			$link->close();
			die ($invalidData);
		}


	} else {
		//Not an admin, redirect to home.
		$NextURL="jane.php";
		header("Location: $NextURL");
	}
}
?>
