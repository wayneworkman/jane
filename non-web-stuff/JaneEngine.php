<?php
include 'vars.php';
include 'verifysession.php';


$sql = "SELECT SettingsTypeID,SettingsTableName FROM janeSettingsTypes";
$result0 = $link->query($sql);
if ($result0->num_rows > 0) {
	while($row0 = $result0->fetch_assoc()) {
		$SettingsTypeID = $row0["SettingsTypeID"];
		$SettingsTableName = $row0["SettingsTableName"];
		$sql = "SELECT JaneSettingsID FROM janeSettings WHERE JaneSettingsTypeID = '$SettingsTypeID'";
		$result1 = $link->query($sql);
		if ($result1->num_rows > 0) {
			while($row1 = $result1->fetch_assoc()) {
				$JaneSettingsID = = $row1["JaneSettingsID"];



				//Here, you filter out each setting type and send the JaneSettingsID to each respective settings type script.


				if ($SettingsTableName = "janeAD") {
					include('janeADEngine.php');
				}



				if ($SettingsTableName = "janeOD") {
					include('janeODEngine.php');
                                }








			}
		}
	}
}
?>

