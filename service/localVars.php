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
$JaneEngine_Sleep_Time = "300"; // 24 hours is 86400 seconds. For testing, 3 minutes can be used without issue, 180 seconds. For most purposes, every 7, 14, or 17 minutes would be fine.
$TimeZone="America/Chicago";
//Find a listing of timezones here:
//  http://php.net/manual/en/timezones.php
date_default_timezone_set($TimeZone);
$PrivateKey = "/jane/ssl/Jane.key";

?>

