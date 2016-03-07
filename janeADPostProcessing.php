<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
	include 'connect2db.php';
	$JaneSettingsID = $link->real_escape_string($_SESSION['JaneSettingsID']);

	if ($isAdministrator == 1) {
		$sql = "SELECT * FROM janeSettings WHERE JaneSettingsID = '$JaneSettingsID'";
	} else {
		$sql = "SELECT * FROM janeSettings WHERE JaneSettingsID = '$JaneSettingsID' and JaneSettingsGroupID = (SELECT gID FROM janeUserGroupAssociation WHERE uID = '$JaneUserID')";
	}
	$result = $link->query($sql);
	if ($result->num_rows > 0) {

		// Escape user inputs for security
		$JaneSettingsNickName = $link->real_escape_string($_REQUEST['JaneSettingsNickName']);
		$JaneSettingsGroupName = $link->real_escape_string($_REQUEST['JaneSettingsGroupName']);
		$JaneSettingsSMBallowedIP = $link->real_escape_string($_REQUEST['JaneSettingsSMBallowedIP']);
		$JaneSettingsWHERE = $link->real_escape_string($_REQUEST['JaneSettingsNickName']);





		$ActionCreate = $link->real_escape_string($_REQUEST['ActionCreate']);
		$ActionDisable = $link->real_escape_string($_REQUEST['ActionDisable']);
		$ActionDelete = $link->real_escape_string($_REQUEST['ActionDelete']);
		$ActionCreateText = $link->real_escape_string($_REQUEST['ActionCreateText']);
		$ActionDisableText = $link->real_escape_string($_REQUEST['ActionDisableText']);
		$ActionDeleteText = $link->real_escape_string($_REQUEST['ActionDeleteText']);
		$Group1Name = $link->real_escape_string($_REQUEST['Group1Name']);
		$Group2Name = $link->real_escape_string($_REQUEST['Group2Name']);
		$Group3Name = $link->real_escape_string($_REQUEST['Group3Name']);
		$Name = $link->real_escape_string($_REQUEST['Name']);
		$AccountExpirationDate = $link->real_escape_string($_REQUEST['AccountExpirationDate']);
		$AccountNotDelegated = $link->real_escape_string($_REQUEST['AccountNotDelegated']);
		$AccountPassword = $link->real_escape_string($_REQUEST['AccountPassword']);
		$AllowReversiblePasswordEncryption = $link->real_escape_string($_REQUEST['AllowReversiblePasswordEncryption']);
		$AuthType = $link->real_escape_string($_REQUEST['AuthType']);
		$CannotChangePassword = $link->real_escape_string($_REQUEST['CannotChangePassword']);
		$ChangePasswordAtLogon = $link->real_escape_string($_REQUEST['ChangePasswordAtLogon']);
		$City = $link->real_escape_string($_REQUEST['City']);
		$Company = $link->real_escape_string($_REQUEST['Company']);
		$Country = $link->real_escape_string($_REQUEST['Country']);
		$Credential  = $link->real_escape_string($_REQUEST['Credential']);
		$Certificates = $link->real_escape_string($_REQUEST['Certificates']);
		$Department = $link->real_escape_string($_REQUEST['Department']);
		$Description = $link->real_escape_string($_REQUEST['Description']);
		$DisplayName = $link->real_escape_string($_REQUEST['DisplayName']);
		$Division = $link->real_escape_string($_REQUEST['Division']);
		$EmailAddress = $link->real_escape_string($_REQUEST['EmailAddress']);
		$EmployeeID = $link->real_escape_string($_REQUEST['EmployeeID']);
		$EmployeeNumber = $link->real_escape_string($_REQUEST['EmployeeNumber']);
		$Enabled = $link->real_escape_string($_REQUEST['Enabled']);
		$Fax = $link->real_escape_string($_REQUEST['Fax']);
		$GivenName = $link->real_escape_string($_REQUEST['GivenName']);
		$HomeDirectory = $link->real_escape_string($_REQUEST['HomeDirectory']);
		$HomeDrive = $link->real_escape_string($_REQUEST['HomeDrive']);
		$HomePage = $link->real_escape_string($_REQUEST['HomePage']);
		$HomePhone = $link->real_escape_string($_REQUEST['HomePhone']);
		$Initials = $link->real_escape_string($_REQUEST['Initials']);
		$Instance = $link->real_escape_string($_REQUEST['Instance']);
		$LogonWorkstations = $link->real_escape_string($_REQUEST['LogonWorkstations']);
		$Manager = $link->real_escape_string($_REQUEST['Manager']);
		$MobilePhone = $link->real_escape_string($_REQUEST['MobilePhone']);
		$Office = $link->real_escape_string($_REQUEST['Office']);
		$OfficePhone = $link->real_escape_string($_REQUEST['OfficePhone']);
		$Organization = $link->real_escape_string($_REQUEST['Organization']);
		$OtherAttributes = $link->real_escape_string($_REQUEST['OtherAttributes']);
		$OtherName = $link->real_escape_string($_REQUEST['OtherName']);
		$PassThru = $link->real_escape_string($_REQUEST['PassThru']);
		$PasswordNeverExpires = $link->real_escape_string($_REQUEST['PasswordNeverExpires']);
		$PasswordNotRequired = $link->real_escape_string($_REQUEST['PasswordNotRequired']);
		$Path = $link->real_escape_string($_REQUEST['Path']);
		$POBox = $link->real_escape_string($_REQUEST['POBox']);
		$PostalCode = $link->real_escape_string($_REQUEST['PostalCode']);
		$ProfilePath = $link->real_escape_string($_REQUEST['ProfilePath']);
		$SamAccountName = $link->real_escape_string($_REQUEST['SamAccountName']);
		$ScriptPath = $link->real_escape_string($_REQUEST['ScriptPath']);
		$Server = $link->real_escape_string($_REQUEST['Server']);
		$ServicePrincipalNames = $link->real_escape_string($_REQUEST['ServicePrincipalNames']);
		$SmartcardLogonRequired = $link->real_escape_string($_REQUEST['SmartcardLogonRequired']);
		$State = $link->real_escape_string($_REQUEST['State']);
		$StreetAddress = $link->real_escape_string($_REQUEST['StreetAddress']);
		$Surname = $link->real_escape_string($_REQUEST['Surname']);
		$Title = $link->real_escape_string($_REQUEST['Title']);
		$TrustedForDelegation = $link->real_escape_string($_REQUEST['TrustedForDelegation']);
		$Type = $link->real_escape_string($_REQUEST['Type']);
		$UserPrincipalName = $link->real_escape_string($_REQUEST['UserPrincipalName']);
		$Confirm = $link->real_escape_string($_REQUEST['Confirm']);
		$WhatIf = $link->real_escape_string($_REQUEST['WhatIf']);



		$sql = "SELECT * FROM janeAD WHERE JaneSettingsID = '$JaneSettingsID'";
		$result = $link->query($sql);
		if ($result->num_rows > 0) {
			// Record exists, UPDATE
			$sql = "UPDATE `janeAD` SET `ActionCreate`='$ActionCreate', `ActionDisable`='$ActionDisable', `ActionDelete`='$ActionDelete', `ActionCreateText`='$ActionCreateText', `ActionDisableText`='$ActionDisableText', `ActionDeleteText`='$ActionDeleteText', `Group1Name`='$Group1Name', `Group2Name`='$Group2Name', `Group3Name`='$Group3Name', `Name`='$Name', `AccountExpirationDate`='$AccountExpirationDate', `AccountNotDelegated`='$AccountNotDelegated', `AccountPassword`='$AccountPassword', `AllowReversiblePasswordEncryption`='$AllowReversiblePasswordEncryption', `AuthType`='$AuthType', `CannotChangePassword`='$CannotChangePassword', `Certificates`='$Certificates', `ChangePasswordAtLogon`='$ChangePasswordAtLogon', `City`='$City', `Company`='$Company', `Country`='$Country', `Credential`='$Credential', `Department`='$Department', `Description`='$Description', `DisplayName`='$DisplayName', `Division`='$Division', `EmailAddress`='$EmailAddress', `EmployeeID`='$EmployeeID', `EmployeeNumber`='$EmployeeNumber', `Enabled`='$Enabled', `Fax`='$Fax', `GivenName`='$GivenName', `HomeDirectory`='$HomeDirectory', `HomeDrive`='$HomeDrive', `HomePage`='$HomePage', `HomePhone`='$HomePhone', `Initials`='$Initials', `Instance`='$Instance', `LogonWorkstations`='$LogonWorkstations', `Manager`='$Manager', `MobilePhone`='$MobilePhone', `Office`='$Office', `OfficePhone`='$OfficePhone', `Organization`='$Organization', `OtherAttributes`='$OtherAttributes', `OtherName`='$OtherName', `PassThru`='$PassThru', `PasswordNeverExpires`='$PasswordNeverExpires', `PasswordNotRequired`='$PasswordNotRequired', `Path`='$Path', `POBox`='$POBox', `PostalCode`='$PostalCode', `ProfilePath`='$ProfilePath', `SamAccountName`='$SamAccountName', `ScriptPath`='$ScriptPath', `Server`='$Server', `ServicePrincipalNames`='$ServicePrincipalNames', `SmartcardLogonRequired`='$SmartcardLogonRequired', `State`='$State', `StreetAddress`='$StreetAddress', `Surname`='$Surname', `Title`='$Title', `TrustedForDelegation`='$TrustedForDelegation', `Type`='$Type', `UserPrincipalName`='$UserPrincipalName', `Confirm`='$Confirm', `WhatIf`='$WhatIf' WHERE `JaneSettingsID` = '$JaneSettingsID';";
		} else {
			// No matching records, INSERT
			$sql = "INSERT INTO `janeAD` (`JaneSettingsID`, `ActionCreate`, `ActionDisable`, `ActionDelete`, `ActionCreateText`, `ActionDisableText`, `ActionDeleteText`, `Group1Name`, `Group2Name`, `Group3Name`, `Name`, `AccountExpirationDate`, `AccountNotDelegated`, `AccountPassword`, `AllowReversiblePasswordEncryption`, `AuthType`, `CannotChangePassword`, `Certificates`, `ChangePasswordAtLogon`, `City`, `Company`, `Country`, `Credential`, `Department`, `Description`, `DisplayName`, `Division`, `EmailAddress`, `EmployeeID`, `EmployeeNumber`, `Enabled`, `Fax`, `GivenName`, `HomeDirectory`, `HomeDrive`, `HomePage`, `HomePhone`, `Initials`, `Instance`, `LogonWorkstations`, `Manager`, `MobilePhone`, `Office`, `OfficePhone`, `Organization`, `OtherAttributes`, `OtherName`, `PassThru`, `PasswordNeverExpires`, `PasswordNotRequired`, `Path`, `POBox`, `PostalCode`, `ProfilePath`, `SamAccountName`, `ScriptPath`, `Server`, `ServicePrincipalNames`, `SmartcardLogonRequired`, `State`, `StreetAddress`, `Surname`, `Title`, `TrustedForDelegation`, `Type`, `UserPrincipalName`, `Confirm`, `WhatIf`) VALUES ('$JaneSettingsID','$ActionCreate','$ActionDisable','$ActionDelete','$ActionCreateText','$ActionDisableText','$ActionDeleteText','$Group1Name','$Group2Name','$Group3Name','$Name','$AccountExpirationDate','$AccountNotDelegated','$AccountPassword','$AllowReversiblePasswordEncryption','$AuthType','$CannotChangePassword','$Certificates','$ChangePasswordAtLogon','$City','$Company','$Country','$Credential','$Department','$Description','$DisplayName','$Division','$EmailAddress','$EmployeeID','$EmployeeNumber','$Enabled','$Fax','$GivenName','$HomeDirectory','$HomeDrive','$HomePage','$HomePhone','$Initials','$Instance','$LogonWorkstations','$Manager','$MobilePhone','$Office','$OfficePhone','$Organization','$OtherAttributes','$OtherName','$PassThru','$PasswordNeverExpires','$PasswordNotRequired','$Path','$POBox','$PostalCode','$ProfilePath','$SamAccountName','$ScriptPath','$Server','$ServicePrincipalNames','$SmartcardLogonRequired','$State','$StreetAddress','$Surname','$Title','$TrustedForDelegation','$Type','$UserPrincipalName','$Confirm','$WhatIf');";
		}




		if ($link->query($sql)) {
			// good, send back to jane.php
			$link->close();
			$NextURL="jane.php";
			header("Location: $NextURL");
		} else {
			// Error
			$link->close();
			die ($SiteErrorMessage);
		}
	} else {
		// user has no permisson to manipulate the given ID or Given ID does not exist.
		$link->close();
		$NextURL="jane.php";
		header("Location: $NextURL");


	}
}
?>
