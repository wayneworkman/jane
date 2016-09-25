<?php

// Database connect settings.
$servername = 'localhost';
$username = 'janeWeb';
$password = 'janewebpassword';
$database = 'jane';
$janeSuperUser = 'janeSuperUser';
$janeSuperUserPassword = 'janesuperuserpassword';

$SessionTimeout = 900; // measured in seconds.
$PasswordDefault = "changeme";
$SiteErrorMessage = "ERROR: There was a site problem. Report this to your Jane administrator and try again later.";
$BadLoginError = "ERROR: Username and/or password is no good.";
$IPBlockedMessage = "ERROR: You are blocked. Report this to your Jane administrator and try again later.";
$incomplete = "ERROR: Not all fields completed.";
$invalidData = "ERROR: Invalid data in one or more fields.";
$PublicKey = "Jane.crt";
$ScriptExample = "RunJaneScripts.ps1";
$tempDir = "/jane/apacheTemp";

//Timezone info.
$TimeZone="America/Chicago";
//Find a listing of timezones here:
//  http://php.net/manual/en/timezones.php
date_default_timezone_set($TimeZone);

$adminActionNames = array();

$AddNewUser = "Add New User";
$adminActionNames[] = $AddNewUser;

$DeleteSelectedUser = "Delete Selected User";
$adminActionNames[] = $DeleteSelectedUser;

$EnableSelectedUser = "Enable Selected User";
$adminActionNames[] = $EnableSelectedUser;

$DisableSelectedUser = "Disable Selected User";
$adminActionNames[] = $DisableSelectedUser;

$ResetSelectedUsersJanePassword = "Reset Selected Users Jane Password to $PasswordDefault";
$adminActionNames[] = $ResetSelectedUsersJanePassword;

$ResetSelectedUsersSMBPassword = "Reset Selected Users SMB Password to $PasswordDefault";
$adminActionNames[] = $ResetSelectedUsersSMBPassword;

$CreateNewGroup = "Create New Group";
$adminActionNames[] = $CreateNewGroup;

$DeleteSelectedGroup = "Delete Selected Group";
$adminActionNames[] = $DeleteSelectedGroup;

$AddSelectedUserToSelectedGroup = "Add Selected User To Selected Group";
$adminActionNames[] = $AddSelectedUserToSelectedGroup;

$RemoveSelectedUserFromSelectedGroup = "Remove Selected User From Selected Group";
$adminActionNames[] = $RemoveSelectedUserFromSelectedGroup;

$BlockIP = "Block IP";
$adminActionNames[] = $BlockIP;

$UnblockIP = "Unblock IP";
$adminActionNames[] = $UnblockIP;









?>

