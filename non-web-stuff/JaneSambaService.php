<?php
include 'localVars.php';
include 'connect2db.php';


// Get list of users not to disturb.
$DoNotDisturbList = array();
$sql = "SELECT SystemUsername FROM LocalUsersNotToDisturb";
$result = $link->query($sql);
if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
                $DoNotDisturbList[] = trim($row["SystemUsername"]);
        }
}
$result->free();
// Get existing users on local system.
$localUsers = shell_exec('cut -d: -f1 /etc/passwd');
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
}
$result->free();
// Users in the database that do not exist locally need created.
$i = 0;
foreach($JaneUsernames as $JaneUsername) {
	foreach($SystemLocalUsers as $SystemLocalUser) {
		if ($JaneUsername == $SystemLocalUser) {
			$found = "true";
			// Update password.
			$command = "echo $JaneSMBPasswords[$i] | passwd $JaneUsernames[$i] --stdin";
			echo shell_exec($command);
			$command = "(echo $JaneSMBPasswords[$i]; echo $JaneSMBPasswords[$i]) | smbpasswd -s $JaneUsernames[$i]";
			echo shell_exec($command);
			break;
		} else {
			$found = "false";
		}
	}
	if ($found == "false") {
		// Make user here
		$command = "useradd $JaneUsernames[$i]";
		echo shell_exec($command);
		$command = "echo $JaneSMBPasswords[$i] | passwd $JaneUsernames[$i] --stdin";
		echo shell_exec($command);
		$command = "(echo $JaneSMBPasswords[$i]; echo $JaneSMBPasswords[$i]) | smbpasswd -a -s $JaneUsernames[$i]";
		echo shell_exec($command);
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
			$command = "smbpasswd -s -x $SystemLocalUsers[$i]";
			echo shell_exec($command);
			$command = "userdel -r $SystemLocalUsers[$i]";
			echo shell_exec($command);
		}
	}
	$i = $i + 1;
	$found = "false";
}



// Get JaneSettings values for shares.
$JaneSettingsNickName = array();
$JaneSettingsGroupID = array();
$JaneSettingsSMBallowedIP = array();
$sql = "SELECT `JaneSettingsNickName`,`JaneSettingsGroupID`,`JaneSettingsSMBallowedIP` FROM `janeSettings`";
$result = $link->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$JaneSettingsNickName[] = trim($row["JaneSettingsNickName"]);
		$JaneSettingsGroupID[] = trim($row["JaneSettingsGroupID"]);
		$JaneSettingsSMBallowedIP[] = trim($row["JaneSettingsSMBallowedIP"]);
	}
}
$result->free();




// Setup directories.
$JaneSettingDirs = array();
$files = scandir($PathToSMBShares);
foreach ($files as $file) {
	if (is_dir("$PathToSMBShares$file")) {
		if ($file != "." && $file != "..") {
			$JaneSettingDirs[] = $file;
			echo "$file\n";
		}
	}
}





// Build smb.conf file.
$i=0;
$smbconf = "";
$smbconf .= "security = user\n";
$smbconf .= "passdb backend = tdbsam\n";
$smbconf .= "unix charset = utf-8\n";
$smbconf .= "dos charset = cp932\n";
foreach($JaneSettingsNickName as $NickName) {
	$smbconf .= "[$NickName]\n";
	$smbconf .= "$PathToSMBShares$NickName\n";
	$smbconf .= "read only = no\n";
	$smbconf .= "$JaneSettingsSMBallowedIP[$i]\n";
	$smbconf .= "create mode = 0777\n";
	$smbconf .= "directory mode = 0777\n";
	$smbconf .= "writable = yes\n";
	$smbconf .= "valid users =";
	$sql = "SELECT `JaneUsername` FROM `janeUsers` WHERE `JaneUserID` IN (SELECT `uID` FROM `janeUserGroupAssociation` WHERE `gID` = $JaneSettingsGroupID[$i])";
	$result = $link->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tmp = trim($row["JaneUsername"]);
			if ($tmp != "") {
				$smbconf .= " $tmp";
			}
		}
	}
	$result->free();
	$smbconf .= "\n";
	$i = $i + 1;
}


echo $smbconf;



?>
