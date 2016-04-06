<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
	include 'connect2db.php';
	echo "<!DOCTYPE html>";
	echo "<html lang=\"en\">";
	echo "<head>";
	echo "<meta charset=\"UTF-8\"/>";
	echo "<title>Jane</title>";
	echo "<style>";
	echo "div{width:600px;padding:10px;border:5px solid gray;margin:0}";
	echo "<!--";
	echo ".tab { margin-left: 40px; }";
	echo "-->";
	echo "</style>";
	echo "</head>";
	echo "<body>";
	
	
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
		$sql = "SELECT JaneSettingsNickName,JaneSettingsID FROM janeSettings";
	} else {
		$sql = "SELECT JaneSettingsNickName,JaneSettingsID FROM janeSettings WHERE JaneSettingsGroupID = (SELECT gID FROM janeUserGroupAssociation WHERE uID = '$JaneUserID')";
	}
	$result = $link->query($sql);
	while($row = $result->fetch_assoc()) {
		echo "<option value='" . $row['JaneSettingsID'] . "'>" . $row['JaneSettingsNickName'] . "</option>";
	}
	echo "</select><br>";
	echo "<br>";
        echo "<input type=\"submit\">";
        echo "</form>";	
	echo "</div>";
	

	echo "<div>";
	echo "<form action=\"ChangeUsername.php\" method=\"post\">";
	echo "Change Username<br>";
	echo "<p class=\"tab\">";
	echo "Old Username:<br><input type=\"text\" name=\"OldUsername\"><br>";
	echo "New Username:<br><input type=\"text\" name=\"NewUsername\"><br>";
	echo "Note:<br>Changing usernames does not affect group membership. This username change will apply to the Jane username and SMB username.<br>";
	echo "<br>";
        echo "<input type=\"submit\">";
        echo "</form>";	
	echo "</div>";


		
	echo "<div>";
	echo "<form action=\"ChangeJanePassword.php\" method=\"post\">";
        echo "Change Jane Password<br>";
        echo "<p class=\"tab\">";
        echo "Old Jane Password:<br><input type=\"password\" name=\"OldJanePassword\"><br>";
        echo "New Jane Password:<br><input type=\"password\" name=\"NewJanePassword\"><br>";
	echo "<br>";
        echo "<input type=\"submit\">";
        echo "</form>";
	echo "</div>";


	echo "<div>";
	echo "<form action=\"ChangeSMBPassword.php\" method=\"post\">";
	echo "Change SMB Password<br>";
	echo "<p class=\"tab\">";
	echo "Old SMB Password:<br><input type=\"password\" name=\"OldSMBPassword\"><br>";
	echo "New SMB Password:<br><input type=\"password\" name=\"NewSMBPassword\"><br>";
	echo "<br>";
	echo "<input type=\"submit\">";
	echo "</form>";
	echo "</div>";



	if ($isAdministrator == 1) {

		echo "<div>";
                echo "<form action=\"NewSettings.php\" method=\"post\">";
                echo "New Settings<br>";
                echo "<p class=\"tab\">";
                echo "<br>";
		echo "Settings Nickname:<br>";
                echo "<input type=\"text\" name=\"NewSettingsNickName\"><br>";
                echo "<br>";
		echo "Settings Type:<br>";
		echo "<select name='NewSettingsType'>";
		echo "<option value='0'>Pick Settings Type</option>";
		$sql = "SELECT SettingsTypeID,SettingsTypeName from janeSettingsTypes";
		$result = $link->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "<option value='" . $row['SettingsTypeID'] . "'>" . $row['SettingsTypeName'] . "</option>";
                        }
		} else {
			echo "<option value='no_users'>no_settings</option>";
		}
		echo "</select><br>";
		echo "<br>";
		echo "Settings Group:<br>";
		echo "<select name='NewSettingsGroup'>";
                echo "<option value='0'>Pick Group</option>";
                $sql = "SELECT JaneGroupID,JaneGroupName from janeGroups";
                $result = $link->query($sql);
                if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['JaneGroupID'] . "'>" . $row['JaneGroupName'] . "</option>";
                        }
                } else {
                        echo "<option value='no_groups'>no_settings</option>";
                }
                echo "</select><br>";
                echo "<br>";

		echo "IP Allowed Access:<br>";
		echo "<input type=\"text\" name=\"JaneSettingsSMBallowedIP\"><br>";
		echo "<br>";

		echo "WHERE:<br>";
		echo "<input type=\"text\" name=\"JaneSettingsWHERE\"><br>";
		echo "The WHERE setting is included as part of the SQL SELECT statement used with selecting data from the bulk data table. Any data matching this WHERE clause will be included in processing for this group of settings. After each returned record's successful processing, these records are deleted from the bulk table.<br>";
                echo "<br>";

		echo "<input type=\"submit\">";
		echo "</form>";
		echo "</div>";

				
		echo "<div>";
		echo "<form action=\"AdminResetJanePass.php\" method=\"post\">";
		echo "Reset Users Jane Password to \"$PasswordDefault\"<br>";
		echo "<p class=\"tab\">";
		echo "<select name='adminResetJanePass'>";
		echo "<option value='0'>Pick User</option>";
		$sql = "SELECT JaneUsername,JaneUserID from janeUsers";
		$result = $link->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "<option value='" . $row['JaneUserID'] . "'>" . $row['JaneUsername'] . "</option>";
			}
		} else {
			echo "<option value='no_users'>no_users</option>";
		}
		echo "</select><br>";
		echo "<br>";
		echo "<input type=\"submit\">";
		echo "</form>";
		echo "</div>";




		echo "<div>";
		echo "<form action=\"AdminResetSMBPass.php\" method=\"post\">";
		echo "Reset Users SMB Password to \"$PasswordDefault\"<br>";
		echo "<p class=\"tab\">";
		echo "<select name='adminResetSMBPass'>";
		echo "<option value='0'>Pick User</option>";
		$sql = "SELECT JaneUsername,JaneUserID from janeUsers";
		$result = $link->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "<option value='" . $row['JaneUserID'] . "'>" . $row['JaneUsername'] . "</option>";
			}
		} else {
			echo "<option value='no_users'>no_users</option>";
		}
		echo "</select><br>";
		echo "<br>";
		echo "<input type=\"submit\">";
		echo "</form>";
		echo "</div>";





		echo "<div>";
		echo "<form action=\"NewUser.php\" method=\"post\">";
		echo "Create New User<br>";
		echo "<p class=\"tab\">";
		echo "Username:<br><input type=\"text\" name=\"NewUsername\"><br>";
		echo "Default password is \"$PasswordDefault\"<br>";
		echo "<br>";
		echo "<input type=\"submit\">";
		echo "</form>";
		echo "</div>";


		echo "<div>";
		echo "<form action=\"NewGroup.php\" method=\"post\">";
		echo "Create New Group<br>";
		echo "<p class=\"tab\">";
		echo "Groupname:<br><input type=\"text\" name=\"NewGroupname\"><br>";
		echo "<br>";
		echo "<input type=\"submit\">";
		echo "</form>";
		echo "</div>";




		echo "<div>";
		echo "<form action=\"AddUserToGroup.php\" method=\"post\">";
		echo "Add User to Group<br>";
		echo "<p class=\"tab\">";
		echo "Group name:<br>";
		echo "<select name='GroupName'>";
		echo "<option value='0'>Pick Group</option>";
		$sql = "SELECT JaneGroupID,JaneGroupName from janeGroups";
		$result = $link->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "<option value='" . $row['JaneGroupID'] . "'>" . $row['JaneGroupName'] . "</option>";
			}
		} else {
			echo "<option value='no_groups'>no_settings</option>";
		}
		echo "</select><br>";
		echo "<br>";
		echo "Username:<br>";
		echo "<select name='UserName'>";
		echo "<option value='0'>Pick User</option>";
		$sql = "SELECT JaneUsername,JaneUserID from janeUsers";
		$result = $link->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "<option value='" . $row['JaneUserID'] . "'>" . $row['JaneUsername'] . "</option>";
			}
		} else {
			echo "<option value='no_users'>no_users</option>";
		}
		echo "</select><br>";
		echo "<br>";
		echo "<input type=\"submit\">";
		echo "</form>";
		echo "</div>";
	}
	echo "<br>";
	echo "</body>";
	echo "</html>";
	$link->close();
}
?>
