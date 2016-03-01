<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
	include 'connect2db.php';
	// Do actions here.
	$Action = $link->real_escape_string($_REQUEST['Action']);
	$JaneSettingsID = $link->real_escape_string($_REQUEST['SettingsNickName']);
	$ConfirmDelete = $link->real_escape_string($_REQUEST['ConfirmDelete']);
	if ($isAdministrator == 1) {
		$sql = "SELECT JaneSettingsID FROM janeSettings WHERE JaneSettingsID = '$JaneSettingsID'";
	} else {
		$sql = "SELECT JaneSettingsNickName,JaneSettingsID FROM janeSettings WHERE JaneSettingsID = '$JaneSettingsID' AND JaneSettingsGroupID = (SELECT gID FROM janeUserGroupAssociation WHERE uID = '$JaneUserID')";
	}
	$result = $link->query($sql);
	if ($result->num_rows > 0) {
		if ($Action == "EditSettings") {
			// Get tablename, SettingsTypeName
			$sql = "SELECT SettingsTableName,SettingsTypeName FROM janeSettingsTypes WHERE SettingsTypeID = (SELECT JaneSettingsTypeID FROM janeSettings WHERE JaneSettingsID = '$JaneSettingsID')";
			$result = $link->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$SettingsTableName = $row["SettingsTableName"];
					$SettingsTypeName = $row["SettingsTypeName"];
				}
			} else {
				// No matching settings type.
				$link->close();
				$NextURL="jane.php";
				header("Location: $NextURL");
			}
			// ------------------------------Begin---------------------------------
			// From here down to the next marker is where custom select code for each settings type would go.
			// You'd select the data from the appropriate table,
			// Then you'd pass that data via session to a page built specifically for the settings type.
			//
			// Available relevant variables at this point are:
			// $JaneSettingsID
			// $SettingsTableName
			// $SettingsTypeName




			//janeAD
			if ($SettingsTableName == "janeAD") {
				include 'janeAD.php';
				$NextURL="janeADPage.php";
				header("Location: $NextURL");
			} // elseif (next settings check) { 






			//-------------------------------END----------------------------------
		} elseif ($Action == "DeleteSettings" && $ConfirmDelete == "Confirmed") {
			// Query settings table name.
			$sql = "SELECT SettingsTableName FROM janeSettingsTypes WHERE SettingsTypeID = (SELECT JaneSettingsTypeID FROM janeSettings WHERE JaneSettingsID = '$JaneSettingsID')";
			$result = $link->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$SettingsTableName = $row["SettingsTableName"];
				}
			} else {
				// No matching settings type.
				$link->close();
				$NextURL="jane.php";
				header("Location: $NextURL");
			}	
			$sql = "DELETE FROM $SettingsTableName WHERE JaneSettingsID = '$JaneSettingsID'";
			if ($link->query($sql)) {
				// good, continue
				$sql = "DELETE FROM janeSettings WHERE JaneSettingsID = '$JaneSettingsID'";
                        	if ($link->query($sql)) {
					// All done, send back to jane.php
					$NextURL="jane.php";
					header("Location: $NextURL");
				} else {
					// Error
					$link->close();
					die ($SiteErrorMessage);
				}
			} else {
                                // Error
                                $link->close();
                                die ($SiteErrorMessage);
                        }
		} else {
			// Not a valid action, send back to jane.php.
			$NextURL="jane.php";
			header("Location: $NextURL");
		}
	} else {
		// Settings don't exist or user doesn't have permission to access them, send back to jane.php.
		$NextURL="jane.php";
		header("Location: $NextURL");
	}
} else {
	$NextURL="login.php";
	header("Location: $NextURL");
}
?>