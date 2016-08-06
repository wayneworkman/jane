<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
	if ($isAdministrator == 1) {
		include 'connect2db.php';
		// Do actions here.
		$JaneSettingsNickName = $link->real_escape_string(trim($_REQUEST['NewSettingsNickName']));
		//Strip spaces from nickname
		$JaneSettingsNickName = str_replace(' ', '', $JaneSettingsNickName);

		$JaneSettingsTypeID = $link->real_escape_string(trim($_REQUEST['NewSettingsType']));
		$JaneSettingsGroupID = $link->real_escape_string(trim($_REQUEST['NewSettingsGroup']));
		$JaneSettingsSMBallowedIP = $link->real_escape_string(trim($_REQUEST['JaneSettingsSMBallowedIP']));
		$JaneSettingsWHERE = $link->real_escape_string(trim($_REQUEST['JaneSettingsWHERE']));

		if (isset($JaneSettingsNickName, $JaneSettingsTypeID, $JaneSettingsGroupID, $JaneSettingsSMBallowedIP, $JaneSettingsWHERE)) {

			$sql = "INSERT INTO janeSettings (JaneSettingsNickName,JaneSettingsWHERE,JaneSettingsGroupID,JaneSettingsTypeID,JaneSettingsSMBallowedIP) VALUES ('$JaneSettingsNickName','$JaneSettingsWHERE','$JaneSettingsGroupID','$JaneSettingsTypeID','$JaneSettingsSMBallowedIP')";
			if ($link->query($sql)) {
				// good, send back to jane.php
				$NextURL="jane.php";
				header("Location: $NextURL");
			} else {
				// Error
				$link->close();
				die ($SiteErrorMessage);
			}
		} else {
			// Not all fields completed.
			$link->close();
			die ($incomplete);
		}
	} else {
		// not an admin, redirect to jane.php
		$NextURL="jane.php";
		header("Location: $NextURL");
	}
} else {
	$NextURL="login.php";
	header("Location: $NextURL");
}
?>
