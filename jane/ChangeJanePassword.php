<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
	include 'connect2db.php';
	include 'functions.php';


	// Do actions here.
	$OldJanePassword = $link->real_escape_string(trim($_REQUEST['OldJanePassword']));
	$NewJanePassword = $link->real_escape_string(trim($_REQUEST['NewJanePassword']));
	
	if ($OldJanePassword == "" ) {
		unset($OldJanePassword);
	}
	if ($NewJanePassword == "" ) {
		unset($NewJanePassword);
	}

	if (isset($OldJanePassword, $NewJanePassword)) {


		$sql = "SELECT `JanePassword` FROM `janeUsers` WHERE `JaneUserID` = '$JaneUserID'";
		$result = $link->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$StoredPassword = trim($row["JanePassword"]);
			}
		}
		if (password_verify($OldJanePassword, $StoredPassword)) {



			$NewJanePassword = password_hash($NewJanePassword, PASSWORD_DEFAULT);
			$sql = "UPDATE `janeUsers` SET `janePassword` = '$NewJanePassword' WHERE `JaneUserID` = $JaneUserID";
			if ($link->query($sql)) {
				// good, send back to jane.php
				$NextURL="jane.php";
				header("Location: $NextURL");
			} else {
				// Error
				$link->close();
				setMessage($SiteErrorMessage,"ChangeJanePasswordPage.php");
			}
		} else {
			//Mistyped password.
			$link->close();
			setMessage($BadLoginError,"ChangeJanePasswordPage.php");
		}
	} else {
		setMessage($incomplete,"ChangeJanePasswordPage.php");
	}
} else {
	$NextURL="login.php";
	header("Location: $NextURL");
}
?>
