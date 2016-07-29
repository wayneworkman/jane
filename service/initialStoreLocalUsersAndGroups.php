<?php

// This file should only be ran once, upon initial setup. Running after initial setup will cause major problems.

include 'localVars.php';
include 'connect2db.php';

$localUsers = shell_exec('cut -d: -f1 /etc/passwd');
$SystemLocalUsers = array();
foreach(preg_split("/((\r?\n)|(\r\n?))/", $localUsers) as $user){
	$SystemLocalUsers[] = $user;
}
echo "\n";
$sql = "truncate table `LocalUsersNotToDisturb`";
if ($link->query($sql)) {
	// good, send back to jane.php
	echo "Successfully truncated the LocalUsersNotToDisturb table.\n";
	foreach ($SystemLocalUsers as $LocalUser) {
		if ($LocalUser != "") {
			$sql = "INSERT INTO LocalUsersNotToDisturb (SystemUsername) VALUES ('$LocalUser')";
			if ($link->query($sql)) {
				// good, send back to jane.php
				echo "Added user \"$LocalUser\" to the LocalUsersNotToDisturb table.\n";
			} else {
				// Error
				echo "COULD NOT ADD \"$LocalUser\" to the LocalUsersNotToDisturb table!\n";
			}
		}
	}
} else {
	// Error
	echo "COULD NOT truncate the LocalUsersNotToDisturb table!\n";
}






$localGroups = shell_exec('cut -d: -f1 /etc/group');
$SystemLocalGroups = array();
foreach(preg_split("/((\r?\n)|(\r\n?))/", $localGroups) as $group){
	$SystemLocalGroups[] = $group;
}
echo "\n";
$sql = "truncate table `LocalGroupsNotToDisturb`";
if ($link->query($sql)) {
	// good, send back to jane.php
	echo "Successfully truncated the LocalGroupsNotToDisturb table.\n";
	foreach ($SystemLocalGroups as $LocalGroup) {
		if ($LocalGroup != "") {
			$sql = "INSERT INTO LocalGroupsNotToDisturb (SystemGroupname) VALUES ('$LocalGroup')";
			if ($link->query($sql)) {
				// good, send back to jane.php
				echo "Added group \"$LocalGroup\" to the LocalGroupsNotToDisturb table.\n";
			} else {
				// Error
				echo "COULD NOT ADD \"$LocalGroup\" to the LocalGroupsNotToDisturb table!\n";
			}
		}
	}
} else {
	// Error
	echo "$sql\n";
	echo "COULD NOT truncate the LocalGroupsNotToDisturb table!\n";
}






?>
