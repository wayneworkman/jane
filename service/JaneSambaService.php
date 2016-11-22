<?php




// Get list of users not to disturb.
$modifyUsersAllowed = "0"; //Initially set this to 0 just in case query totally fails.
$DoNotDisturbList = array();
$sql = "SELECT SystemUsername FROM LocalUsersNotToDisturb";
$result = $link->query($sql);
if ($result) {
	if ($result->num_rows > 0) {
		$modifyUsersAllowed = "1";
		while($row = $result->fetch_assoc()) {
			$DoNotDisturbList[] = trim($row["SystemUsername"]);
		}
		$result->free();
	}
} else {
	//This query should never return empty - ever. If it does, do not touch users.
	$modifyUsersAllowed = "0";
	writeLog("Query for LocalUsersNotToDisturb returned nothing! Not touching users!");
}


if ($modifyUsersAllowed == "1") {

	// Get existing users on local system.
	$command = 'cut -d: -f1 /etc/passwd';
	$localUsers = shell_exec($command);
	$SystemLocalUsers = array();
	foreach(preg_split("/((\r?\n)|(\r\n?))/", $localUsers) as $user){
		$add = "true";
		foreach ($DoNotDisturbList as $DoNotDisturb) {
			if ($user == $DoNotDisturb) {
				// Don't bother this user.
				$add = "false";
				break;
			}
		}
		if ($add == "true") {
			$SystemLocalUsers[] = $user;
		}
	}
	// Get list of users that should be there.
	$JaneUsernames = array();
	$JaneSMBPasswords = array();
	$JaneUserIDs = array();
	$sql = "SELECT `JaneUsername`,`JaneSMBPassword`,`JaneUserID` FROM `janeUsers` WHERE `JaneUserEnabled` = 1";
	$result = $link->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$JaneUsernames[] = trim($row["JaneUsername"]);
			$JaneSMBPasswords[] = trim($row["JaneSMBPassword"]);
			$JaneUserIDs[] = trim($row["JaneUserID"]);
		}
		$result->free();
	}
	// Users in the database that do not exist locally need created.
	$i = 0;
	foreach($JaneUsernames as $JaneUsername) {
		foreach($SystemLocalUsers as $SystemLocalUser) {
			if ($JaneUsername == $SystemLocalUser) {
				$found = "true";
				// Update password for Linux user and Samba user.
				$command = "chpasswd <<< '$JaneUsernames[$i]:$JaneSMBPasswords[$i]'";
				shell_exec($command);
				$command = "(echo '$JaneSMBPasswords[$i]'; echo '$JaneSMBPasswords[$i]') | smbpasswd -s '$JaneUsernames[$i]'";
				shell_exec($command);
				break;
			} else {
				$found = "false";
			}
		}
		if ($found == "false") {
			// Make user here
			writeLog("Creating user '$JaneUsernames[$i]'");
			$command = "useradd '$JaneUsernames[$i]'";
			shell_exec($command);
			$command = "chpasswd <<< '$JaneUsernames[$i]:$JaneSMBPasswords[$i]'";
			shell_exec($command);
			$command = "(echo '$JaneSMBPasswords[$i]'; echo '$JaneSMBPasswords[$i]') | smbpasswd -a -s '$JaneUsernames[$i]'";
			shell_exec($command);
		}
		$i = $i + 1;
	}
	// users that exist locally but not in the database need deleted.
	$i=0;
	foreach($SystemLocalUsers as $SystemLocalUser) {
		foreach($JaneUsernames as $JaneUsername) {
			if ($SystemLocalUser == $JaneUsername) {
				//Found, don't delete.
				$found = "true";
				break;
			} else {
				$found = "false";
			}
		}
		if ($found == "false") {
			if ($SystemLocalUsers[$i] != "") {
				//Delete the acccount.
				writeLog("Deleting user '$SystemLocalUsers[$i]'");
				$command = "smbpasswd -s -x '$SystemLocalUsers[$i]'";
				shell_exec($command);
				$command = "userdel -r '$SystemLocalUsers[$i]'";
				shell_exec($command);
			}
		}
		$i = $i + 1;
		$found = "false";
	}
}




//--------------Groups---------------//


// Get list of groups not to disturb.
$modifyGroupsAllowed = "0"; //Initially set this to 0, just in case the query totally fails.
$DoNotDisturbList = "";
$DoNotDisturbList = array();
$sql = "SELECT SystemGroupname FROM LocalGroupsNotToDisturb";
$result = $link->query($sql);
if ($result) {
	if ($result->num_rows > 0) {
		$modifyGroupsAllowed = "1";
		while($row = $result->fetch_assoc()) {
			$DoNotDisturbList[] = trim($row["SystemGroupname"]);
		}
		$result->free();
	}
} else {
	//This query should never return empty - ever. If it does, do not touch groups.
	$modifyGroupsAllowed = "0";
	writeLog("Query for LocalGroupsNotToDisturb returned nothing! Not touching groups!");
}


if ($modifyGroupsAllowed == "1") {


	// Add usernames to list of groups not to distrub as user's default groups should not be distrubed while the user exists.
	foreach($JaneUsernames as $JaneUsername) {
		//This is a valid user's group, don't mess with it.
		$DoNotDisturbList[] = $JaneUsername;
	}


	$command = "cut -d: -f1 /etc/group";
	$localGroups = shell_exec($command);
	$SystemLocalGroups = array();
	foreach(preg_split("/((\r?\n)|(\r\n?))/", $localGroups) as $group){
		$add = "true";
		foreach ($DoNotDisturbList as $DoNotDisturb) {
			if ($group == $DoNotDisturb) {
				// Don't bother this group.
				$add = "false";
				break;
			}
		}
		if ($add == "true") {
			$SystemLocalGroups[] = $group;
		}
	}


	// Get list of groups that should be there.
	$JaneGroupNames = array();
	$sql = "SELECT JaneGroupName FROM janeGroups";
	$result = $link->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$JaneGroupNames[] = trim($row["JaneGroupName"]);
		}
		$result->free();
	}





	// Groups in the database that do not exist locally need created.
	$i = 0;
	foreach($JaneGroupNames as $JaneGroupName) {
		foreach($SystemLocalGroups as $SystemLocalGroup) {
			if ($JaneGroupName == $SystemLocalGroup) {
				$found = "true";
				//Do nothing here.
				break;
			} else {
				$found = "false";
			}
		}
		if ($found == "false") {
			// Make group here
			writeLog("Creating group '$JaneGroupNames[$i]'");
			$command = "groupadd '$JaneGroupNames[$i]'";
			shell_exec($command);
		}
		$i = $i + 1;
	}


	// Groups that exist locally but not in the database need deleted.
	$i=0;
	foreach($SystemLocalGroups as $SystemLocalGroup) {
		foreach($JaneGroupNames as $JaneGroupName) {
			if ($SystemLocalGroup == $JaneGroupName) {
				//Found, don't delete.
				$found = "true";
				break;
			} else {
				//Not found yet.
				$found = "false";
			}
		}
		if ($found == "false") {
			if ($SystemLocalGroups[$i] != "") {
				//Delete the group.
				writeLog("Deleting group '$SystemLocalGroups[$i]'");
				$command = "groupdel '$SystemLocalGroups[$i]'";
				shell_exec($command);
			}
		}
		$i = $i + 1;
		$found = "false";
	}

	// Remove all users from all groups except for their own.
	foreach($JaneUsernames as $JaneUsername) {
		$command = "usermod -G '$JaneUsername' '$JaneUsername'";
		shell_exec($command);
	}




	// place users into the correct secondary groups.
	$i = 0;
	foreach($JaneUserIDs as $ID) {
		$sql = "SELECT JaneGroupName FROM janeGroups WHERE JaneGroupID IN (SELECT gID FROM janeUserGroupAssociation WHERE uID = $ID)";
		$result = $link->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$tmp = trim($row["JaneGroupName"]);
				$command = "usermod -a -G '$tmp' '$JaneUsernames[$i]'";
				shell_exec($command);
			}
		$result->free();
		}
	$i = $i + 1;
	}

}


// ------------------- end groups ---------------//




// --------------- Begin directory and samba management ----------------//



if ($modifyUsersAllowed == "1" && $modifyGroupsAllowed == "1") {


	// Get JaneSettings values for shares.
	$JaneSettingsGroupName = array();
	$sql = "SELECT `JaneGroupName` FROM `janeGroups`";
	$result = $link->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$JaneSettingsGroupName[] = trim($row["JaneGroupName"]);
		}
	}
	$result->free();




	// Get local jane directories.
	$JaneSettingDirs = array();
	$files = scandir($PathToSMBShares);
	foreach ($files as $file) {
		if (is_dir("$PathToSMBShares$file")) {
			if ($file != "." && $file != "..") {
				$JaneSettingDirs[] = $file;
			}
		}
	}

	// If it exists in the DB but not locally, make it.
	foreach($JaneSettingsGroupName as $GroupName) {
		$found = "false";
		foreach($JaneSettingDirs as $dir) {
			if ($GroupName == $dir) {
				$found = "true";
				break;
			}
		}
		$isUserGroup = "false";
		foreach($JaneUsernames as $JaneUsername) {
			if ($GroupName == $JaneUsername) {
				//This is a user group, don't make a directory for it.
				$isUserGroup = "true";
				break;
			}
		}
		if ($isUserGroup == "true") {
			continue;
		}
		if ($found == "false") {
			// Make directory here.
			if ($GroupName != "") {
				writeLog("Creating directory '$PathToSMBShares$GroupName'");
				$command = "mkdir '$PathToSMBShares$GroupName'";
				shell_exec($command);
				$command = "chown -R root:'$GroupName' '$PathToSMBShares$GroupName'";
				shell_exec($command);
				$command = "chmod -R 770 '$PathToSMBShares$GroupName'";
				shell_exec($command);
			}
		} else {
			if ($GroupName != "") {
				//Here, the directory already exists and should be there, but we are going to reset ownership to the proper ownership.
				$command = "chown -R root:'$GroupName' '$PathToSMBShares$GroupName'";
				shell_exec($command);
				$command = "chmod -R 770 '$PathToSMBShares$GroupName'";
				shell_exec($command);
			}
		}
	}

	// Don't delete existing folders. 
	//No need because groups and users are cleaned every iteration, permissions and ownership are set ever iteration.






	// Build smb.conf file.
	$i=0;
	$smbconf = "";
	$smbconf .= "security = user\n";
	$smbconf .= "passdb backend = tdbsam\n";
	$smbconf .= "unix charset = utf-8\n";
	$smbconf .= "dos charset = cp932\n";
	$smbconf .= "[imports]\n";
	$smbconf .= "path = $PathToSMBShares" . "imports\n";
	$smbconf .= "read only = no\n";
	$smbconf .= "hosts allow = $ImportIP\n";
	$smbconf .= "create mode = 0777\n";
	$smbconf .= "directory mode = 0777\n";
	$smbconf .= "writable = yes\n";
	$smbconf .= "valid users = jane\n";





	foreach($JaneSettingsGroupName as $GroupName) {
		$smbconf .= "[$GroupName]\n";
		$smbconf .= "path = $PathToSMBShares$GroupName\n";
		$smbconf .= "read only = no\n";


		$JaneSettingsSMBallowedIP = "";
		$sql = "SELECT `JaneSettingsSMBallowedIP` FROM `janeSettings` WHERE `JaneSettingsGroupID` IN (SELECT JaneGroupID from janeGroups where JaneGroupName = '$GroupName')";
		$result = $link->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$JaneSettingsSMBallowedIP .= trim($row["JaneSettingsSMBallowedIP"]) . " ";
			}
			$result->free();
		}

		//Remove duplicate IPs.
		$AllowedIPArray = explode( " " , $JaneSettingsSMBallowedIP );
		$AllowedIPArray = array_unique( $AllowedIPArray );
		$JaneSettingsSMBallowedIP = implode(" " , $AllowedIPArray);



		$smbconf .= "hosts allow = $JaneSettingsSMBallowedIP\n";
		$smbconf .= "create mode = 0777\n";
		$smbconf .= "directory mode = 0777\n";
		$smbconf .= "writable = yes\n";
		$smbconf .= "valid users =";
		$sql = "SELECT `JaneUsername` FROM `janeUsers` WHERE `JaneUserID` IN (SELECT `uID` FROM `janeUserGroupAssociation` WHERE `gID` IN (SELECT JaneGroupID from janeGroups where JaneGroupName = '$GroupName'))";
		$result = $link->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$tmp = trim($row["JaneUsername"]);
				if ($tmp != "") {
					$smbconf .= " $tmp";
				}
			}
			$result->free();
		}
		$smbconf .= "\n";
		$i = $i + 1;
	}





	// Write the conf file to the temp location.
	if (file_exists($tmpFile)) {
		unlink($tmpFile);
		if (file_exists($tmpFile)) {
			writeLog("Deleting the temporary SMB config file from \"$tmpFile\" failed for some reason. Check permissions and maybe SELinux. Ensure that JaneEngine.php is running as root.");
		} else {
			file_put_contents($tmpFile, $smbconf);
		}
	} else {
		file_put_contents($tmpFile, $smbconf);
	}








	//Checksum of current file.
	if (file_exists($SMB_TO_USE)) {
		$Current_SMB_Checksum = sha1_file($SMB_TO_USE);
		//Check it twice.
		$tmp = sha1_file($SMB_TO_USE);
		if ($tmp != $Current_SMB_Checksum) {
			writeLog("The SMB configuration file \"$SMB_TO_USE\" failed to be checksumed correctly.\n No action will be taken with the SMB configuration file or the SMB service.\n This can be due to RAM issues, a failing HDD or possibly other causes.");
			$Current_SMB_Checksum = "0";
		}
	} else {
		writeLog("The SMB configuration file \"$SMB_TO_USE\" does not exist.\n Because of this, the temporary SMB file will not be swapped out in place of where the current SMB file should be.\n You should investigate why it's missing.\n Is the path correct? Is Samba installed? Are permissions OK? Could it be SELinux?");
		$Current_SMB_Checksum = "0";
	}






	//Checksum of new file.
	if (file_exists($tmpFile)) {
		$New_SMB_Checksum = sha1_file($tmpFile);
		//Check it twice.
		$tmp = sha1_file($tmpFile);
		if ($tmp != $New_SMB_Checksum) {
			writeLog("The new SMB configuration file \"$tmpFile\" failed to be checksumed correctly.\n No action will be taken with the SMB configuration file or the SMB service.\n This can be due to RAM issues, a failing HDD or possibly other causes.");
			$New_SMB_Checksum = "1";
		}
	} else {
		writeLog("The new SMB configuration file \"$tmpFile\" was supposed to be written moments ago, but does not exist.\n Because of this, the temporary SMB file will not be moved into the position of the current SMB file.\n Something might be wrong with permissions, the path, or possibly SELinux.\n The partition might be full as well. You should investigate.");
		$New_SMB_Checksum = "1";
	}







	if ($Current_SMB_Checksum != $New_SMB_Checksum) {
		if ($New_SMB_Checksum != "1" && $Current_SMB_Checksum != "0") {
			writeLog("Configuration changes detected, updating the Samba configuration file.");
			writeLog("Moving \"$SMB_TO_USE\" to \"$SMB_TO_USE.old\", then moving \"$tmpFile\" to \"$SMB_TO_USE\"");
			// Move old file.
			if (file_exists($SMB_TO_USE)) {
				// Delete pre-existing old file.
				if (file_exists("$SMB_TO_USE.old")) {
					unlink("$SMB_TO_USE.old");
				}
				// Move current to old.
				rename($SMB_TO_USE, "$SMB_TO_USE.old");
			}
			// Place new file.
			rename($tmpFile, $SMB_TO_USE);
			// Restart smb service.
			writeLog("Restarting Samba.");
			$command = 'systemctl restart smb';
			shell_exec($command);
		}
	}

} else {
	writeLog("Because a user or group query failed, not touching local directories or current Samba configurations.");

}

//--------------------------- End directory and samba management -----------------//

?>
