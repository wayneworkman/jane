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
	echo "div{padding:10px;border:5px solid gray;margin:0}";
	echo "<!--";
	echo ".tab { margin-left: 40px; }";
	echo "-->";
	echo "</style>";
	echo "</head>";
	echo "<body>";
	
	

	echo "<div>";
	echo "<a href=\"logout.php\">Log Out</a><br>";
	echo "<a href=\"LICENSE\">License</a><br>";
	echo "<a href=\"DownloadKey.php\">Download Jane Public Key</a><br><br>";
	echo "</div>";


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
		$sql = "SELECT JaneSettingsNickName,JaneSettingsID FROM janeSettings WHERE JaneSettingsGroupID IN (SELECT gID FROM janeUserGroupAssociation WHERE uID = '$JaneUserID')";
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
        echo "Old Jane Password:<br><input type=\"password\" name=\"OldJanePassword\" autocomplete=\"off\"><br>";
        echo "New Jane Password:<br><input type=\"password\" name=\"NewJanePassword\" autocomplete=\"off\"><br>";
	echo "<br>";
        echo "<input type=\"submit\">";
        echo "</form>";
	echo "</div>";


	echo "<div>";
	echo "<form action=\"ChangeSMBPassword.php\" method=\"post\">";
	echo "Change SMB Password<br>";
	echo "<p class=\"tab\">";
	echo "Old SMB Password:<br><input type=\"password\" name=\"OldSMBPassword\" autocomplete=\"off\"><br>";
	echo "New SMB Password:<br><input type=\"password\" name=\"NewSMBPassword\" autocomplete=\"off\"><br>";
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
				echo "<option value='" . trim($row['SettingsTypeID']) . "'>" . trim($row['SettingsTypeName']) . "</option>";
                        }
			$result->free();
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
                                echo "<option value='" . trim($row['JaneGroupID']) . "'>" . trim($row['JaneGroupName']) . "</option>";
                        }
			$result->free();
                } else {
                        echo "<option value='no_groups'>no_settings</option>";
                }
                echo "</select><br>";
                echo "<br>";

		echo "IP Allowed Access:<br>";
		echo "<input type=\"text\" name=\"JaneSettingsSMBallowedIP\" style=\"width:600px;\"><br>";
		echo "<br>";

		echo "WHERE:<br>";
		echo "<input type=\"text\" name=\"JaneSettingsWHERE\" style=\"width:600px;\"><br>";
		echo "Examples:<br>";
                echo "<font color=\"red\">userGroup = &#39;Site 5&#39;</font><br>";
                echo "<font color=\"red\">userGroup = &#39;South Branch&#39;</font><br>";
                echo "<font color=\"red\">userGroup = &#39;Site 7&#39; OR userGroup = &#39;Site 8&#39;</font><br>";
                echo "<br>";
                echo "The WHERE setting is included as part of the SQL SELECT statement used with selecting data from the <font color=\"red\">userDataToImport</font> table. Any data matching this WHERE clause will be included in processing for this group of settings. No escaping is performed on these values because they are directly used upon the database. Therefore they are only available to administrators.<br>";
                echo "<br>";

		echo "<input type=\"submit\">";
		echo "</form>";
		echo "</div>";

		


		echo "<div>";
		echo "<form action=\"AdminAction.php\" method=\"post\">";
		echo "User, Group, and IP Management<br>";
		echo "<p class=\"tab\">";

		
		echo "Text for selected action:<br><input type=\"text\" name=\"adminActionText\"><br>";
		echo "<br>";


		$GroupIDs = array();
		$GroupNames = array();
		$UserIDs = array();
		$UserNames = array();

		echo "<select name='uID'>";
		echo "<option value=''>Pick User</option>";
		$sql = "SELECT JaneUsername,JaneUserID from janeUsers";
		$result = $link->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "<option value='" . trim($row['JaneUserID']) . "'>" . trim($row['JaneUsername']) . "</option>";
				$UserIDs[] = trim($row['JaneUserID']);
				$UserNames[] = trim($row['JaneUsername']);
			}
			$result->free();
		} else {
			echo "<option value='no_users'>no_users</option>";
		}
		echo "</select>";

		echo "<select name='gID'>";
		echo "<option value=''>Pick Group</option>";
		$sql = "SELECT JaneGroupID,JaneGroupName from janeGroups";
		$result = $link->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "<option value='" . trim($row['JaneGroupID']) . "'>" . trim($row['JaneGroupName']) . "</option>";
				$GroupIDs[] = trim($row['JaneGroupID']);
				$GroupNames[] = trim($row['JaneGroupName']);
			}
			$result->free();
		} else {
			echo "<option value='no_groups'>no_settings</option>";
		}
		echo "</select><br>";
		echo "<br>";
		
		$i = 0;
		foreach ($adminActionNames as $adminAction) {
			echo "<input type=\"radio\" name=\"adminAction\" value=\"$adminAction\">$adminAction<br>";
			$i = $i + 1;
		}

		echo "<br>";
		echo "<input type=\"submit\">";
		echo "</form>";
		echo "</div>";







		echo "<div>";
		echo "<form>";
		echo "Lists and Recent things<br>";
		echo "<p class=\"tab\">";

		// List group's users, and user's groups.	


		echo "List of all groups, and the users in each:<br><br>";
		$i = 0;
		foreach ($GroupIDs as $GroupID) {
			$sql = "SELECT `JaneUsername` FROM `janeUsers` WHERE `JaneUserID` IN (SELECT `uID` FROM `janeUserGroupAssociation` WHERE `gID` = '$GroupID')";
			$result = $link->query($sql);
			echo "&emsp;&emsp;$GroupNames[$i]<br>";
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					echo "&emsp;&emsp;&emsp;&emsp;" . $row["JaneUsername"] . "<br>";
				}
				$result->free();
			}
			echo "<br>";
			$i = $i + 1;
		}


		echo "List of all users, and the groups they are in.<br><br>";
		$i = 0;
                foreach ($UserIDs as $UserID) {
                        $sql = "SELECT `JaneGroupName` FROM `janeGroups` WHERE `JaneGroupID` IN (SELECT `gID` FROM `janeUserGroupAssociation` WHERE `uID` = '$UserID')";
                        $result = $link->query($sql);
                        echo "&emsp;&emsp;$UserNames[$i]<br>";
                        if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                        echo "&emsp;&emsp;&emsp;&emsp;" . $row["JaneGroupName"] . "<br>";
                                }
				$result->free();
                        }
                        echo "<br>";
                        $i = $i + 1;
                }


		$sql = "SELECT `BlockedIP` FROM `blockedIPs`";
		$result = $link->query($sql);
		echo "List of blocked IPs:<br>";
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "&emsp;&emsp;" . $row["BlockedIP"] . "<br>";
			}
			$result->free();
		}
		echo "<br>";




		//Recent bad login attempts.
		echo "<font color=\"red\">Recent bad login attempts:</font><br>";
		$sql = "SELECT badUsername,badREMOTE_ADDR,badHTTP_USER_AGENT FROM badLoginAttempts ORDER BY badREQUEST_TIME desc LIMIT 40";
		$result = $link->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "<br>";
				echo "&emsp;&emsp;" . $row["badUsername"] . "<br>";
				echo "&emsp;&emsp;" . $row["badREMOTE_ADDR"] . "<br>";
				echo "&emsp;&emsp;" . $row["badHTTP_USER_AGENT"] . "<br>";
			}
			$result->free();
                }
		echo "</div>";
		echo "</form>";

	}
	echo "<br>";
	echo "</body>";
	echo "</html>";
	$link->close();
}
?>
