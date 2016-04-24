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

$adminActionNames = array();
$adminActionNames[] = "Add New User";
$adminActionNames[] = "Delete Selected User";
$adminActionNames[] = "Enable Selected User";
$adminActionNames[] = "Disable Selected User";
$adminActionNames[] = "Reset Selected Users Jane Password to \"$PasswordDefault\"";
$adminActionNames[] = "Reset Selected Users SMB Password to \"$PasswordDefault\"";
$adminActionNames[] = "Create New Group";
$adminActionNames[] = "Delete Selected Group";
$adminActionNames[] = "Add Selected User To Selected Group";
$adminActionNames[] = "Remove Selected User From Selected Group";



?>

