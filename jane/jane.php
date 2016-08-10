<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
	include 'connect2db.php';
	include 'head.php';
	echo "<title>Home</title>";

	echo "<div>";
	echo "<form action=\"EditOrDeleteSettings.php\" method=\"post\">";
	echo "Edit or Delete Settings<br>";
	echo "<p class=\"tab\">";
	echo "<input type=\"radio\" name=\"Action\" value=\"EditSettings\" checked>Edit Settings<br>";
        echo "<input type=\"radio\" name=\"Action\" value=\"DeleteSettings\">Delete Settings";
	echo "<input type=\"checkbox\" name=\"ConfirmDelete\" value=\"Confirmed\">Confirm Delete<br>";
	echo "<br>";
	echo "<p class=\"tab\">";
	echo "<select name='SettingsNickName'>";
	echo "<option value='0'>Pick Settings NickName</option>";
	if ($isAdministrator == 1) {
		$sql = "SELECT `JaneSettingsNickName`,`JaneSettingsID` FROM `janeSettings`";
	} else {
		$sql = "SELECT `JaneSettingsNickName`,`JaneSettingsID` FROM `janeSettings` WHERE `JaneSettingsGroupID` IN (SELECT `gID` FROM `janeUserGroupAssociation` WHERE `uID` = '$JaneUserID')";
	}
	$result = $link->query($sql);
	while($row = $result->fetch_assoc()) {
		echo "<option value='" . trim($row['JaneSettingsID']) . "'>" . trim($row['JaneSettingsNickName']) . "</option>";
	}
	echo "</select><br>";
	echo "<br>";
        echo "<input type=\"submit\">";
        echo "</form>";	
	echo "</div>";
		



	echo "<br>";
	echo "</body>";
	echo "</html>";
	$link->close();
}
?>
