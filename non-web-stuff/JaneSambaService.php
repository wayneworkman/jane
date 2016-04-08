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






//--------------Groups---------------//


// Get list of groups not to disturb.
$DoNotDisturbList = "";
$DoNotDisturbList = array();
$sql = "SELECT SystemGroupname FROM LocalGroupsNotToDisturb";
$result = $link->query($sql);
if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
                $DoNotDisturbList[] = trim($row["SystemGroupname"]);
        }
}
$result->free();


$localGroups = shell_exec('cut -d: -f1 /etc/group');
$SystemLocalGroups = array();
foreach(preg_split("/((\r?\n)|(\r\n?))/", $localGroups) as $group){
        $SystemLocalGroups[] = $group;
}


// Get list of groups that should be there.
$JaneGroupNames = array();
$sql = "SELECT JaneGroupName FROM janeGroups";
$result = $link->query($sql);
if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
                $JaneGroupNames[] = trim($row["JaneGroupName"]);
        }
}
$result->free();


// Groups in the database that do not exist locally need created.
$i = 0;
foreach($JaneGroupNames as $JaneGroupName) {
	foreach($SystemLocalGroups as $SystemLocalGroup) {
		if ($JaneGroupName == $SystemLocalGroup) {
			$found = "true";
			break;
		} else {
			$found = "false";
		}
	}
	if ($found == "false") {
		// Make group here
		$command = "groupadd $JaneGroupNames[$i]";
		echo shell_exec($command);
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
			$found = "false";
		}
	}
	if ($found == "false") {
		if ($SystemLocalGroups[$i] != "") {
			//Delete the group.
			$command = "groupdel $SystemLocalGroups[$i]";
			echo shell_exec($command);
		}
	}
	$i = $i + 1;
	$found = "false";
}



?>
