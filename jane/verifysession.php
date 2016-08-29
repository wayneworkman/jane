<?php
include 'vars.php';
include 'connect2db.php';
$SessionIsVerified="0";
$isAdministrator="0";
session_start();
$REMOTE_ADDR = $link->real_escape_string($_SERVER ['REMOTE_ADDR']);
$sql = "SELECT BlockedIP FROM blockedIPs WHERE BlockedIP = '$REMOTE_ADDR' LIMIT 1";
$result = $link->query($sql);
if ($result->num_rows == 0) {
	// Get remote info and fingerprint.
	$UserFingerprint = $link->real_escape_string($_SESSION['fingerprint']);
	$REQUEST_TIME = $link->real_escape_string($_SERVER ['REQUEST_TIME']);
	if (isset($_SERVER["HTTP_USER_AGENT"])) {
        	$HTTP_USER_AGENT = $link->real_escape_string($_SERVER ['HTTP_USER_AGENT']);
	} else {
        	$HTTP_USER_AGENT = "No HTTP_USER_AGENT header set.";
	}
	$sql = "SELECT SessionUserID,Random_String,REQUEST_TIME FROM Sessions WHERE fingerprint = '$UserFingerprint' LIMIT 1";
	$result = $link->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
        		$JaneUserID = $row["SessionUserID"];
			$Random_String = $row["Random_String"];
			$oldREQUEST_TIME = $row["REQUEST_TIME"];
		}
	} else {
	// No matching session info, send to login screen.
	session_unset();
	session_destroy();
	$link->close();
	$NextURL="login.php";
	header("Location: $NextURL");
	}
	$sql = "SELECT JaneUserEnabled FROM janeUsers WHERE JaneUserID = '$JaneUserID' LIMIT 1";
	$result = $link->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$JaneUserEnabled = $row["JaneUserEnabled"];
		}
	} else {
	// No matching user info, send to login screen.
	// FIY this particular bit of code should never even be executed logically.
	session_unset();
	session_destroy();
	$link->close();
	$NextURL="login.php";
	header("Location: $NextURL");
	}
	$RawFingerprint = $JaneUserID . $REMOTE_ADDR . $HTTP_USER_AGENT . $Random_String;
	if (password_verify($RawFingerprint, $UserFingerprint) && (($REQUEST_TIME - $oldREQUEST_TIME) <= $SessionTimeout) && ($JaneUserEnabled == "1")) {
		// Session is verified, refresh it.
		$fingerprint = password_hash("$RawFingerprint", PASSWORD_DEFAULT);
		$bytes = openssl_random_pseudo_bytes(32, $cstrong);
		$Random_String = $link->real_escape_string(bin2hex($bytes));
		$RawFingerprint = $JaneUserID . $REMOTE_ADDR . $HTTP_USER_AGENT . $Random_String;
		$fingerprint = password_hash("$RawFingerprint", PASSWORD_DEFAULT);
		$sql = "INSERT INTO Sessions (REQUEST_TIME,SessionUserID,REMOTE_ADDR,HTTP_USER_AGENT,Random_String,fingerprint) VALUES ('$REQUEST_TIME','$JaneUserID','$REMOTE_ADDR','$HTTP_USER_AGENT','$Random_String','$fingerprint')";
		if ($link->query($sql)) {
			$_SESSION['fingerprint'] = $fingerprint;
			// All done, Send user along.
			$SessionIsVerified="1";
			// Determine if it's an administrator or not.
			$sql = "SELECT uID FROM janeUserGroupAssociation WHERE uID = '$JaneUserID' AND gID = (SELECT JaneGroupID FROM janeGroups WHERE JaneGroupName = 'administrators') LIMIT 1";
			$result = $link->query($sql);
			if ($result->num_rows == 1) {
				$isAdministrator = "1";
			} else {
				$isAdministrator = "0";
			}
			$link->close();
		} else {
			// Couldn't insert new session data into DB.
			$SessionIsVerified="0";
			$link->close();
			die ($SiteErrorMessage);
		}
	} else {
		// Session is not verified or timed out.
		$SessionIsVerified="0";	
		//redirect to login screen.
		session_destroy();
		session_unset();
		$NextURL="login.php";
		header("Location: $NextURL");
	}
} else {
// IP is blocked.
$link->close();
session_unset();
session_destroy();
session_start();
$_SESSION['badLoginAttempt'] = "1";
$_SESSION['ErrorMessage'] = $IPBlockedMessage;
$NextURL="login.php";
header("Location: $NextURL");
}
?>
