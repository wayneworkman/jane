<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
	if ($isAdministrator == 1) {
		include 'connect2db.php';


		//Function to do SQL query.
		function doQuery() {
			global $sql;
			global $link;
			global $SiteErrorMessage;
			global $NextURL;
			echo "$sql<br>";
			if ($link->query($sql)) {
				// good, send back to NextURL
				$NextURL="jane.php";
				header("Location: $NextURL");
			} else {
				// Error
				die ($SiteErrorMessage);
			}
		}




		//Get data from form submission.
		$adminAction = $link->real_escape_string(trim($_REQUEST['adminAction']));
		$adminActionText = $link->real_escape_string(trim($_REQUEST['adminActionText']));
		$uID = $link->real_escape_string(trim($_REQUEST['uID']));
		$gID = $link->real_escape_string(trim($_REQUEST['gID']));

		echo "$adminAction<br>";


		//Determine action and carry out action.

		switch ($adminAction) {

			case $AddNewUser:
				if ($adminActionText != "" && $PasswordDefault != "") {
					$NewPassword = password_hash($PasswordDefault, PASSWORD_DEFAULT);
					$sql = "INSERT INTO `janeUsers` (`JaneUsername`,`JanePassword`,`JaneSMBPassword`,`JaneUserEnabled`) VALUES ('$adminActionText','$NewPassword','$PasswordDefault','1')";
					doQuery();
				}
				break;

			case $DeleteSelectedUser:
				if ($uID != "") {
					$sql = "DELETE FROM `janeUserGroupAssociation` WHERE `uID` = '$uID'";
					doQuery();
					$sql = "DELETE FROM `Sessions` WHERE `SessionUserID` = '$uID'";
					doQuery();
					$sql = "DELETE FROM `janeUsers` WHERE `JaneUserID` = '$uID'";
					doQuery();
				}
				break;
			case $EnableSelectedUser:
				if ($uID != "") {
					$sql = "UPDATE `janeUsers` SET `JaneUserEnabled` = '1' WHERE `JaneUserID` = '$uID'";
					doQuery();
				}
				break;
			case $DisableSelectedUser:
				if ($uID != "") {
					$sql = "UPDATE `janeUsers` SET `JaneUserEnabled` = '0' WHERE `JaneUserID` = '$uID'";
					doQuery();
				}
				break;
			case $ResetSelectedUsersJanePassword:
				if ($uID != "") {
					$NewPassword = password_hash($PasswordDefault, PASSWORD_DEFAULT);
					$sql = "UPDATE `janeUsers` SET `JanePassword` = '$NewPassword' WHERE `JaneUserID` = $uID";
					doQuery();
				}
				break;
			case $ResetSelectedUsersSMBPassword:
				if ($uID != "") {
					$sql = "UPDATE `janeUsers` SET `JaneSMBPassword` = '$PasswordDefault' WHERE `JaneUserID` = $uID";
					doQuery();
				}
				break;
			case $CreateNewGroup:
				if ($adminActionText != "") {
					$sql = "INSERT INTO `janeGroups` (`JaneGroupName`) VALUES ('$adminActionText')";
					doQuery();
				}
				break;
			case $DeleteSelectedGroup:
				if ($gID != "") {
					$sql = "DELETE FROM `janeUserGroupAssociation` WHERE `gID` = '$gID'";
					doQuery();
					$sql = "DELETE FROM `janeGroups` WHERE `JaneGroupID` = '$gID'";
					doQuery();
				}
				break;
			case $AddSelectedUserToSelectedGroup:
				if ($gID != "" && $uID != "") {
					$sql = "INSERT INTO janeUserGroupAssociation (uID,gID) VALUES ($uID,$gID)";
					doQuery();
				}
				break;
			case $RemoveSelectedUserFromSelectedGroup:
				if ($gID != "" && $uID != "") {
					$sql = "DELETE FROM `janeUserGroupAssociation` WHERE `uID` = '$uID' AND `gID` = '$gID'";
					doQuery();
				}
				break;
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
