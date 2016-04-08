<?php

// Database connect settings.
$servername = 'localhost';
$username = 'janeSystem';
$password = 'janesystempassword';
$database = 'jane';
$PathToSMBShares = '/jane/';
$PathToCSV = '/root/testdata.csv';
$SMB_TO_USE="/etc/samba/smb.conf";
$tmpFile = "$SMB_TO_USE.tmp";
$ImportIP = "10.51.1.85";
$SMB_SLEEP_TIME = "3600"; // 1 hour.
$JaneEngine_Sleep_Time = "86400"; // 24 hours.
?>

