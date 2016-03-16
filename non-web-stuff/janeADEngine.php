<?php
$sql = "SELECT JaneSettingsNickName,JaneSettingsWHERE,JaneSettingsSMBallowedIP FROM janeSettings WHERE JaneSettingsID = '$JaneSettingsID' LIMIT 1";
$result = $link->query($sql);
if ($result->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()) {
		$JaneSettingsNickName = $row["JaneSettingsNickName"];
		$JaneSettingsWHERE = $row["JaneSettingsWHERE"];
	}
}

$sql = "SELECT * FROM janeAD WHERE JaneSettingsID = '$JaneSettingsID' LIMIT 1";
$result = $link->query($sql);
if ($result->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()) {
		$ActionCreate = $row["ActionCreate"];
		$ActionDisable = $row["ActionDisable"];
		$ActionDelete = $row["ActionDelete"];
		$ActionCreateText = $row["ActionCreateText"];
		$ActionDisableText = $row["ActionDisableText"];
		$ActionDeleteText = $row["ActionDeleteText"];
		$Group1Name = $row["Group1Name"];
		$Group2Name = $row["Group2Name"];
		$Group3Name = $row["Group3Name"];
		$Name = $row["Name"];
		$AccountExpirationDate = $row["AccountExpirationDate"];
		$AccountNotDelegated = $row["AccountNotDelegated"];
		$AccountPassword = $row["AccountPassword"];
		$AllowReversiblePasswordEncryption = $row["AllowReversiblePasswordEncryption"];
		$AuthType = $row["AuthType"];
		$CannotChangePassword = $row["CannotChangePassword"];
		$Certificates = $row["Certificates"];
		$ChangePasswordAtLogon = $row["ChangePasswordAtLogon"];
		$City = $row["City"];
		$Company = $row["Company"];
		$Country = $row["Country"];
		$Credential = $row["Credential"];
		$Department = $row["Department"];
		$Description = $row["Description"];
		$DisplayName = $row["DisplayName"];
		$Division = $row["Division"];
		$EmailAddress = $row["EmailAddress"];
		$EmployeeID = $row["EmployeeID"];
		$EmployeeNumber = $row["EmployeeNumber"];
		$Enabled = $row["Enabled"];
		$Fax = $row["Fax"];
		$GivenName = $row["GivenName"];
		$HomeDirectory = $row["HomeDirectory"];
		$HomeDrive = $row["HomeDrive"];
		$HomePage = $row["HomePage"];
		$HomePhone = $row["HomePhone"];
		$Initials = $row["Initials"];
		$Instance = $row["Instance"];
		$LogonWorkstations = $row["LogonWorkstations"];
		$Manager = $row["Manager"];
		$MobilePhone = $row["MobilePhone"];
		$Office = $row["Office"];
		$OfficePhone = $row["OfficePhone"];
		$Organization = $row["Organization"];
		$OtherAttributes = $row["OtherAttributes"];
		$OtherName = $row["OtherName"];
		$PassThru = $row["PassThru"];
		$PasswordNeverExpires = $row["PasswordNeverExpires"];
		$PasswordNotRequired = $row["PasswordNotRequired"];
		$Path = $row["Path"];
		$POBox = $row["POBox"];
		$PostalCode = $row["PostalCode"];
		$ProfilePath = $row["ProfilePath"];
		$SamAccountName = $row["SamAccountName"];
		$ScriptPath = $row["ScriptPath"];
		$Server = $row["Server"];
		$ServicePrincipalNames = $row["ServicePrincipalNames"];
		$SmartcardLogonRequired = $row["SmartcardLogonRequired"];
		$State = $row["State"];
		$StreetAddress = $row["StreetAddress"];
		$Surname = $row["Surname"];
		$Title = $row["Title"];
		$TrustedForDelegation = $row["TrustedForDelegation"];
		$Type = $row["Type"];
		$UserPrincipalName = $row["UserPrincipalName"];
		$Confirm = $row["Confirm"];
		$WhatIf = $row["WhatIf"];
	}
}


?>
