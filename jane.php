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
        echo "<input type=\"radio\" name=\"Action\" value=\"DeleteSettings\">Delete Settings<br>";
	echo "<p class=\"tab\">";
	echo "<select name='SettingsNickName'>";
	echo "<option value='0'>Pick Settings NickName</option>";
	if (isAdministrator == 1) {
		$sql = "SELECT JaneSettingsNickName FROM janeSettings";
	} else {
		$sql = "SELECT JaneSettingsNickName FROM janeSettings WHERE JaneSettingsGroupID = (SELECT gID FROM janeUserGroupAssociation WHERE uID = '$JaneUserID')";
	}
	$result = $link->query($sql);
	while($row = $result->fetch_assoc()) {
		echo "<option value='" . $row['JaneSettingsNickName'] . "'>" . $row['JaneSettingsNickName'] . "</option>";
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
	echo "Note:<br>Changing usernames does not affect group membership.<br>";
	echo "<br>";
        echo "<input type=\"submit\">";
        echo "</form>";	
	echo "</div>";


		
	echo "<div>";
	echo "<form action=\"ChangePassword.php\" method=\"post\">";
        echo "Change Password<br>";
        echo "<p class=\"tab\">";
        echo "Old Password:<br><input type=\"text\" name=\"OldPassword\"><br>";
        echo "New Password:<br><input type=\"text\" name=\"NewPassword\"><br>";
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
                echo "<input type=\"submit\">";
                echo "</form>";
                echo "</div>";

				
		echo "<div>";
		echo "<form action=\"AdminResetPass.php\" method=\"post\">";
		echo "Reset Users Password to \"changeme\"<br>";
		echo "<p class=\"tab\">";
		echo "<select name='adminResetPass'>";
		echo "<option value='0'>Pick User</option>";
		$sql = "SELECT JaneUsername from janeUsers";
		$result = $link->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "<option value='" . $row['JaneUsername'] . "'>" . $row['JaneUsername'] . "</option>";
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
		echo "Default password is \"changeme\"<br>";
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
