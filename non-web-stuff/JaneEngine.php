<?php
include 'localVars.php';
include 'connect2db.php';

while(1) {

$sql = "SELECT SettingsTypeID,SettingsTableName FROM janeSettingsTypes";
$result0 = $link->query($sql);
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


sleep($JaneEngine_Sleep_Time);

} // end loop.

$link->close();
?>

