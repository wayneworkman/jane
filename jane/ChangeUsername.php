<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
	include 'connect2db.php';


	// Do actions here.
	$OldUsername = $link->real_escape_string(trim($_REQUEST['OldUsername']));
	$NewUsername = $link->real_escape_string(trim($_REQUEST['NewUsername']));
	
	//Strip spaces.
	$NewUsername = str_replace(' ', '', $NewUsername);

	if ($OldUsername == "") {
		unset($OldUsername);
	}

	if ($NewUsername == "") {
		unset($NewUsername);
	}

	if (isset($OldUsername, $NewUsername)) {

		$sql = "UPDATE `janeUsers` SET `janeUsername` = '$NewUsername' WHERE `JaneUserID` = $JaneUserID and `JaneUserName`='$OldUsername'";


		if ($link->query($sql)) {
			// good, send back to jane.php
			$NextURL="jane.php";
			header("Location: $NextURL");
		} else {
			// Error
			$link->close();
			die ($SiteErrorMessage);
		}
	} else {
		die ($incomplete);
	}

} else {
	$NextURL="login.php";
	header("Location: $NextURL");
}
?>

