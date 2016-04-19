<?php

// Database connect settings.
$servername = 'localhost';
$username = 'janeSystem';
$password = 'janesystempassword';
$database = 'jane';
$PathToSMBShares = '/jane/';
$PathToCSV = '/jane/imports/FF_AddsDrops.csv';
$SMB_TO_USE="/etc/samba/smb.conf";
$tmpFile = "$SMB_TO_USE.tmp";
$ImportIP = "10.51.1.85";
$SMB_SLEEP_TIME = "3600"; // 1 hour.
$JaneEngine_Sleep_Time = "180"; // 24 hours is 86400 and is default. For testing, 3 minutes can be used without issue. 180 seconds.

?>

