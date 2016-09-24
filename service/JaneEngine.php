<?php
include 'localVars.php';
include 'connect2db.php';
include 'functions.php';

while(1) {
	include 'JaneSambaService.php';
	include 'readcsv.php';


	$sql = "SELECT SettingsTypeID,SettingsTableName FROM janeSettingsTypes";
	$result0 = $link->query($sql);
	if ($result0) {
		if ($result0->num_rows > 0) {
			while($row0 = $result0->fetch_assoc()) {
				$SettingsTypeID = trim($row0["SettingsTypeID"]);
				$SettingsTableName = trim($row0["SettingsTableName"]);
				$sql = "SELECT JaneSettingsID FROM janeSettings WHERE JaneSettingsTypeID = '$SettingsTypeID'";
				$result1 = $link->query($sql);
				if ($result1->num_rows > 0) {
					while($row1 = $result1->fetch_assoc()) {
						$JaneSettingsID = trim($row1["JaneSettingsID"]);

						//Here, you filter out each setting type and send the JaneSettingsID to each respective settings type script.

						//Active Directory
						if ($SettingsTableName = "janeAD") {
							include('janeADEngine.php');
						}


						//Open Directory
						if ($SettingsTableName = "janeOD") {
							include('janeODEngine.php');
						}


						//Other goes here


					}
				}
			}
		}

		// Destroy data in table.
		$sql = "TRUNCATE TABLE userDataToImport";
		if ($link->query($sql)) {
			// good
		} else {
			// Error
			$link->close();
			die ($SiteErrorMessage);
		}

	}
	include 'JaneSambaService.php';
	sleep($JaneEngine_Sleep_Time);

} // end loop.

$link->close();
?>

