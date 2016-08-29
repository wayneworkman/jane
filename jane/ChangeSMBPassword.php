<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
	include 'connect2db.php';
	include 'functions.php';

	// Do actions here.
	$OldSMBPassword = $link->real_escape_string(trim($_REQUEST['OldSMBPassword']));
	$NewSMBPassword = $link->real_escape_string(trim($_REQUEST['NewSMBPassword']));
	if ($OldSMBPassword != "" && $NewSMBPassword != "") {

		$sql = "SELECT `JaneSMBPassword` FROM `janeUsers` WHERE `JaneUserID` = '$JaneUserID' and `JaneSMBPassword` = '$OldSMBPassword'";
		$result = $link->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$StoredSMBPassword = trim($row["JaneSMBPassword"]);
			}
		}

		if ($StoredSMBPassword == "") {
			unset($StoredSMBPassword);
		}
		if ($OldSMBPassword == "") {
			unset($OldSMBPassword);
		}
		if ($NewSMBPassword == "") {
			unset($NewSMBPassword);
		}

		if (!isset($StoredSMBPassword, $OldSMBPassword, $NewSMBPassword)) {
			setMessage($incomplete,"ChangeSMBPasswordPage.php");
		}



		if ($StoredSMBPassword == $OldSMBPassword) {

			$sql = "UPDATE `janeUsers` SET `JaneSMBPassword` = '$NewSMBPassword' WHERE `JaneUserID` = $JaneUserID";
			if ($link->query($sql)) {
				// good, send back to jane.php
				$NextURL="jane.php";
				header("Location: $NextURL");
			} else {
				// Error
				$link->close();
				setMessage($SiteErrorMessage,"ChangeSMBPasswordPage.php");
			}
		} else {
                        //Mistyped password.
                        $link->close();
			setMessage($BadLoginError,"ChangeSMBPasswordPage.php");
                }
	} else {
		setMessage($incomplete,"ChangeSMBPasswordPage.php");
	}

} else {
	$NextURL="login.php";
	header("Location: $NextURL");
}
?>
