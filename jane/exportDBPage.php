<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
	if ($isAdministrator == 1) {

		//generate filename first, based on date/time.
		$rightNow = new DateTime("@" . time());
		$rightNow->setTimezone(new DateTimeZone("$TimeZone"));
		$fileName = "JaneDB-Backup-" . $rightNow->format("Y-m-d-H:i:s") . ".sql";

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($fileName).'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');

		$file = shell_exec("mysqldump --add-drop-table --host=$servername --user=$janeSuperUser --password=$janeSuperUserPassword --databases $database");

		echo $file;
		exit;


	} else {
		//Not an admin, redirect to home.
		$NextURL="jane.php";
		header("Location: $NextURL");
	}
}
?>
