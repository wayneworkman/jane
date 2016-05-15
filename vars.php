<?php

// Database connect settings.
$servername = 'localhost';
$username = 'janeWeb';
$password = 'janewebpassword';
$database = 'jane';
$SessionTimeout = 900; // measured in seconds.
$PasswordDefault = "changeme";
$SiteErrorMessage = "ERROR: There was a site problem. Report this to your Jane administrator and try again later.";
$BadLoginError = "ERROR: Username and/or password is no good.";
$IPBlockedMessage = "ERROR: You are blocked. Report this to your Jane administrator and try again later.";
$PublicKey = "Jane.crt";


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

