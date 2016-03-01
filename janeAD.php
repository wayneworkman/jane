<?PHP
include 'vars.php';
if ($SessionIsVerified == "1") {
	include 'connect2db.php';



	$sql = "SELECT JaneSettingsNickName,JaneSettingsWHERE,JaneSettingsGroupID,JaneSettingsSMBallowedIP FROM janeSettings WHERE JaneSettingsID = '$JaneSettingsID' LIMIT 1";
	$result = $link->query($sql);
	if ($result->num_rows > 0) {
        	// output data of each row
        	while($row = $result->fetch_assoc()) {
			$_SESSION['JaneSettingsNickName'] = $row["JaneSettingsNickName"];
			$_SESSION['JaneSettingsWHERE'] = $row["JaneSettingsWHERE"];
			$JaneSettingsGroupID = $row["JaneSettingsGroupID"];
			$_SESSION['JaneSettingsSMBallowedIP'] = $row["JaneSettingsSMBallowedIP"];
		}
	} else {
		//NO settings? This should never happen at this point.
		$link->close();
		$NextURL="jane.php";
		header("Location: $NextURL");
	}

	$sql = "SELECT JaneGroupName FROM janeGroups WHERE JaneGroupID = '$JaneSettingsGroupID' LIMIT 1";
	$result = $link->query($sql);
	if ($result->num_rows > 0) {
        	// output data of each row
		while($row = $result->fetch_assoc()) {
			$_SESSION['JaneSettingsGroupName'] = $row["JaneGroupName"];
		}
	} else {
        	//NO Group Name? This should never happen at this point.
        	$link->close();
        	$NextURL="jane.php";
        	header("Location: $NextURL");
	}




	$sql = "SELECT * FROM janeAD WHERE JaneSettingsID = '$JaneSettingsID' LIMIT 1";
	$result = $link->query($sql);
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$_SESSION['Name'] = $row["Name"];
			$_SESSION['AccountExpirationDate'] = $row["AccountExpirationDate"];
			$_SESSION['AccountNotDelegated'] = $row["AccountNotDelegated"];
			$_SESSION['AccountPassword'] = $row["AccountPassword"];
			$_SESSION['AllowReversiblePasswordEncryption'] = $row["AllowReversiblePasswordEncryption"];
			$_SESSION['AuthType'] = $row["AuthType"];
			$_SESSION['CannotChangePassword'] = $row["CannotChangePassword"];
			$_SESSION['Certificates'] = $row["Certificates"];
			$_SESSION['ChangePasswordAtLogon'] = $row["ChangePasswordAtLogon"];
			$_SESSION['City'] = $row["City"];
			$_SESSION['Company'] = $row["Company"];
			$_SESSION['Country'] = $row["Country"];
			$_SESSION['Credential'] = $row["Credential"];
			$_SESSION['Department'] = $row["Department"];
			$_SESSION['Description'] = $row["Description"];
			$_SESSION['DisplayName'] = $row["DisplayName"];
			$_SESSION['Division'] = $row["Division"];
			$_SESSION['EmailAddress'] = $row["EmailAddress"];
			$_SESSION['EmployeeID'] = $row["EmployeeID"];
			$_SESSION['EmployeeNumber'] = $row["EmployeeNumber"];
			$_SESSION['Enabled'] = $row["Enabled"];
			$_SESSION['Fax'] = $row["Fax"];
			$_SESSION['GivenName'] = $row["GivenName"];
			$_SESSION['HomeDirectory'] = $row["HomeDirectory"];
			$_SESSION['HomeDrive'] = $row["HomeDrive"];
			$_SESSION['HomePage'] = $row["HomePage"];
			$_SESSION['HomePhone'] = $row["HomePhone"];
			$_SESSION['Initials'] = $row["Initials"];
			$_SESSION['Instance'] = $row["Instance"];
			$_SESSION['LogonWorkstations'] = $row["LogonWorkstations"];
			$_SESSION['Manager'] = $row["Manager"];
			$_SESSION['MobilePhone'] = $row["MobilePhone"];
			$_SESSION['Office'] = $row["Office"];
			$_SESSION['OfficePhone'] = $row["OfficePhone"];
			$_SESSION['Organization'] = $row["Organization"];
			$_SESSION['OtherAttributes'] = $row["OtherAttributes"];
			$_SESSION['OtherName'] = $row["OtherName"];
			$_SESSION['PassThru'] = $row["PassThru"];
			$_SESSION['PasswordNeverExpires'] = $row["PasswordNeverExpires"];
			$_SESSION['PasswordNotRequired'] = $row["PasswordNotRequired"];
			$_SESSION['Path'] = $row["Path"];
			$_SESSION['POBox'] = $row["POBox"];
			$_SESSION['PostalCode'] = $row["PostalCode"];
			$_SESSION['ProfilePath'] = $row["ProfilePath"];
			$_SESSION['SamAccountName'] = $row["SamAccountName"];
			$_SESSION['ScriptPath'] = $row["ScriptPath"];
			$_SESSION['Server'] = $row["Server"];
			$_SESSION['ServicePrincipalNames'] = $row["ServicePrincipalNames"];
			$_SESSION['SettingsWHERE'] = $row["SettingsWHERE"];
			$_SESSION['SmartcardLogonRequired'] = $row["SmartcardLogonRequired"];
			$_SESSION['State'] = $row["State"];
			$_SESSION['StreetAddress'] = $row["StreetAddress"];
			$_SESSION['Surname'] = $row["Surname"];
			$_SESSION['Title'] = $row["Title"];
			$_SESSION['TrustedForDelegation'] = $row["TrustedForDelegation"];
			$_SESSION['Type'] = $row["Type"];
			$_SESSION['UserPrincipalName'] = $row["UserPrincipalName"];
			$_SESSION['Confirm'] = $row["Confirm"];
			$_SESSION['WhatIf'] = $row["WhatIf"];
		}
	} else {
		// no rows, set all fields as empty.
		$_SESSION['Name'] = "";
		$_SESSION['AccountExpirationDate'] = "";
		$_SESSION['AccountNotDelegated'] = "";
		$_SESSION['AccountPassword'] = "";
		$_SESSION['AllowReversiblePasswordEncryption'] = "";
		$_SESSION['AuthType'] = "";
		$_SESSION['CannotChangePassword'] = "";
		$_SESSION['Certificates'] = "";
		$_SESSION['ChangePasswordAtLogon'] = "";
		$_SESSION['City'] = "";
		$_SESSION['Company'] = "";
		$_SESSION['Country'] = "";
		$_SESSION['Credential'] = "";
		$_SESSION['Department'] = "";
		$_SESSION['Description'] = "";
		$_SESSION['DisplayName'] = "";
		$_SESSION['Division'] = "";
		$_SESSION['EmailAddress'] = "";
		$_SESSION['EmployeeID'] = "";
		$_SESSION['EmployeeNumber'] = "";
		$_SESSION['Enabled'] = "";
		$_SESSION['Fax'] = "";
		$_SESSION['GivenName'] = "";
		$_SESSION['HomeDirectory'] = "";
		$_SESSION['HomeDrive'] = "";
		$_SESSION['HomePage'] = "";
		$_SESSION['HomePhone'] = "";
		$_SESSION['Initials'] = "";
		$_SESSION['Instance'] = "";
		$_SESSION['LogonWorkstations'] = "";
		$_SESSION['Manager'] = "";
		$_SESSION['MobilePhone'] = "";
		$_SESSION['Office'] = "";
		$_SESSION['OfficePhone'] = "";
		$_SESSION['Organization'] = "";
		$_SESSION['OtherAttributes'] = "";
		$_SESSION['OtherName'] = "";
		$_SESSION['PassThru'] = "";
		$_SESSION['PasswordNeverExpires'] = "";
		$_SESSION['PasswordNotRequired'] = "";
		$_SESSION['Path'] = "";
		$_SESSION['POBox'] = "";
		$_SESSION['PostalCode'] = "";
		$_SESSION['ProfilePath'] = "";
		$_SESSION['SamAccountName'] = "";
		$_SESSION['ScriptPath'] = "";
		$_SESSION['Server'] = "";
		$_SESSION['ServicePrincipalNames'] = "";
		$_SESSION['SettingsWHERE'] = "";
		$_SESSION['SmartcardLogonRequired'] = "";
		$_SESSION['State'] = "";
		$_SESSION['StreetAddress'] = "";
		$_SESSION['Surname'] = "";
		$_SESSION['Title'] = "";
		$_SESSION['TrustedForDelegation'] = "";
		$_SESSION['Type'] = "";
		$_SESSION['UserPrincipalName'] = "";
		$_SESSION['Confirm'] = "";
		$_SESSION['WhatIf'] = "";
	}
}
?>
