<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
	if ($isAdministrator == 1) {
		include 'connect2db.php';
		include 'functions.php';


		//Function to do SQL query.
		function doQuery() {
			global $sql;
			global $link;
			global $SiteErrorMessage;
			global $NextURL;
			//echo "$sql<br>";
			if ($link->query($sql)) {
				// good, send back to NextURL
				$NextURL="AdminActionPage.php";
				header("Location: $NextURL");
			} else {
				// Error
				setMessage($SiteErrorMessage,"AdminActionPage.php");
			}
		}




		//Get data from form submission.
		$adminAction = $link->real_escape_string(trim($_REQUEST['adminAction']));
		$adminActionText = $link->real_escape_string(trim($_REQUEST['adminActionText']));
		

		$uID = $link->real_escape_string(trim($_REQUEST['uID']));
		$gID = $link->real_escape_string(trim($_REQUEST['gID']));


		//Strip spaces
		$adminActionText = str_replace(' ', '', $adminActionText);


		//If adminActionText is nothing, unset it.
		if ($adminActionText == "") {
			unset($adminActionText);
		}


		//if uID is nothing, unset it.
		if ($uID == "") {
			unset($uID);
		}

		//if gID is nothing, unset it.
		if ($gID == "") {
			unset($gID);
		}


		//Determine action and carry out action.
		switch ($adminAction) {

			case $AddNewUser:
				if (isset($adminActionText, $PasswordDefault)) {
					$NewPassword = password_hash($PasswordDefault, PASSWORD_DEFAULT);
					$sql = "INSERT INTO `janeUsers` (`JaneUsername`,`JanePassword`,`JaneSMBPassword`,`JaneUserEnabled`) VALUES ('$adminActionText','$NewPassword','$PasswordDefault','1')";
					doQuery();
				} else {
					setMessage($incomplete,"AdminActionPage.php");
				}
				break;

			case $DeleteSelectedUser:
				if (isset($uID)) {
					$sql = "DELETE FROM `janeUserGroupAssociation` WHERE `uID` = '$uID'";
					doQuery();
					$sql = "DELETE FROM `Sessions` WHERE `SessionUserID` = '$uID'";
					doQuery();
					$sql = "DELETE FROM `janeUsers` WHERE `JaneUserID` = '$uID'";
					doQuery();
				} else {
					setMessage($incomplete,"AdminActionPage.php");
                                }
				break;
			case $EnableSelectedUser:
				if (isset($uID)) {
					$sql = "UPDATE `janeUsers` SET `JaneUserEnabled` = '1' WHERE `JaneUserID` = '$uID'";
					doQuery();
				} else {
                                        setMessage($incomplete,"AdminActionPage.php");
                                }
				break;
			case $DisableSelectedUser:
				if (isset($uID)) {
					$sql = "UPDATE `janeUsers` SET `JaneUserEnabled` = '0' WHERE `JaneUserID` = '$uID'";
					doQuery();
				} else {
                                        setMessage($incomplete,"AdminActionPage.php");
                                }
				break;
			case $ResetSelectedUsersJanePassword:
				if (isset($uID)) {
					$NewPassword = password_hash($PasswordDefault, PASSWORD_DEFAULT);
					$sql = "UPDATE `janeUsers` SET `JanePassword` = '$NewPassword' WHERE `JaneUserID` = $uID";
					doQuery();
				} else {
                                        setMessage($incomplete,"AdminActionPage.php");
                                }
				break;
			case $ResetSelectedUsersSMBPassword:
				if (isset($uID)) {
					$sql = "UPDATE `janeUsers` SET `JaneSMBPassword` = '$PasswordDefault' WHERE `JaneUserID` = $uID";
					doQuery();
				} else {
                                        setMessage($incomplete,"AdminActionPage.php");
                                }
				break;
			case $CreateNewGroup:
				if (isset($adminActionText)) {
					$sql = "INSERT INTO `janeGroups` (`JaneGroupName`) VALUES ('$adminActionText')";
					doQuery();
				} else {
                                        setMessage($incomplete,"AdminActionPage.php");
                                }
				break;
			case $DeleteSelectedGroup:
				if (isset($gID)) {
					$sql = "DELETE FROM `janeUserGroupAssociation` WHERE `gID` = '$gID'";
					doQuery();
					$sql = "DELETE FROM `janeGroups` WHERE `JaneGroupID` = '$gID'";
					doQuery();
				} else {
                                        setMessage($incomplete,"AdminActionPage.php");
                                }
				break;
			case $AddSelectedUserToSelectedGroup:
				if (isset($gID, $uID)) {
					$sql = "INSERT INTO janeUserGroupAssociation (uID,gID) VALUES ($uID,$gID)";
					doQuery();
				} else {
                                        setMessage($incomplete,"AdminActionPage.php");
                                }
				break;
			case $RemoveSelectedUserFromSelectedGroup:
				if (isset($gID, $uID)) {
					$sql = "DELETE FROM `janeUserGroupAssociation` WHERE `uID` = '$uID' AND `gID` = '$gID'";
					doQuery();
				} else {
                                        setMessage($incomplete,"AdminActionPage.php");
                                }
				break;
			case $BlockIP:
				if (isset($adminActionText)) {
					$sql = "INSERT INTO `blockedIPs` (`BlockedIP`) VALUES ('$adminActionText')";
					doQuery();
				} else {
                                        setMessage($incomplete,"AdminActionPage.php");
                                }
				break;
			case $UnblockIP:
				if (isset($adminActionText)) {
					$sql = "DELETE FROM `blockedIPs` WHERE `BlockedIP` = '$adminActionText'";
					doQuery();
				} else {
                                        setMessage($incomplete,"AdminActionPage.php");
                                }
				break;
			default:
				setMessage($incomplete,"AdminActionPage.php");
		}







	} else {
		// not an admin, redirect to jane.php
		$NextURL="jane.php";
		header("Location: $NextURL");
	}
} else {
	$NextURL="login.php";
	header("Location: $NextURL");
}
$link->close();
?>
