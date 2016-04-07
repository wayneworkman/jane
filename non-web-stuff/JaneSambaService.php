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
	}
	$i = $i + 1;
}


// users that exist locally but not in the database need deleted.




?>
