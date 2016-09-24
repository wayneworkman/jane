<?php


//Write message to log.
function writeLog($theMessage) {
	global $TimeZone;
	$rightNow = new DateTime("@" . time());
	$rightNow->setTimezone(new DateTimeZone("$TimeZone"));
	echo $rightNow->format("F j, Y, g:i a") . " $theMessage\n";
}


?>
