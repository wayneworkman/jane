<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
	include 'connect2db.php';
	if ($isAdministrator == 1) {


		$years = $link->real_escape_string(trim($_REQUEST['years']));

		if (is_int($years)) {
			$timeDifference = ( date() - ($years * 31536000)); // 1 year in seconds is 31536000.


			$sql = "DELETE FROM `usernameTracking` WHERE `lastSeen` <= '$timeDifference'";
			if ($link->query($sql)) {
				// good, send back to usernameTracking.
				$NextURL="usernameTracking.php";
				header("Location: $NextURL");
			} else {
				// Error
				$link->close();
				die ($SiteErrorMessage);
			}
		}


	} else {
		//Not an admin, redirect to home.
		$NextURL="jane.php";
		header("Location: $NextURL");
	}
}
?>
