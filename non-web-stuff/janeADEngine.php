<?php
$sql = "SELECT JaneSettingsNickName,JaneSettingsWHERE FROM janeSettings WHERE JaneSettingsID = '$JaneSettingsID' LIMIT 1";
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
} else {
	$ActionCreate = "";
	$ActionDisable = "";
	$ActionDelete = "";
	$ActionCreateText = "";
	$ActionDisableText = "";
	$ActionDeleteText = "";
}


if ($ActionCreate != "" && $ActionCreateText != "") {
	//make sure user does NOT exist first (powershell).

	$COMMAND = "if (Get-aduser %UserName%)" . "\r\n" . "{" . "\r\n" . "echo \"This user already exists. Making sure it's enabled.\"" . "\r\n" . "Enable-ADAccount -Identity %UserName%" . "\r\n" . "}" . "\r\n" . "else" . "\r\n" . "{" . "\r\n";
	


	$COMMAND = $COMMAND . "new-aduser ";
	
	if ($Name != "") {
		$COMMAND = $COMMAND . "-Name " . $Name . " ";
	}
	if ($AccountExpirationDate != "") {
		$COMMAND = $COMMAND . "-AccountExpirationDate " . $AccountExpirationDate . " ";
	}
	if ($AccountNotDelegated != "") {
		$COMMAND = $COMMAND . "-AccountNotDelegated " . $AccountNotDelegated . " ";
	}
	if ($AccountPassword != "") {
		$COMMAND = $COMMAND . "-AccountPassword " . $AccountPassword . " ";
	}
	if ($AllowReversiblePasswordEncryption != "") {
		$COMMAND = $COMMAND . "-AllowReversiblePasswordEncryption " . $AllowReversiblePasswordEncryption . " ";
	}
	if ($AuthType != "") {
		$COMMAND = $COMMAND . "-AuthType " . $AuthType . " ";
	}
	if ($CannotChangePassword != "") {
		$COMMAND = $COMMAND . "-CannotChangePassword " . $CannotChangePassword . " ";
	}
	if ($Certificates != "") {
		$COMMAND = $COMMAND . "-Certificates " . $Certificates . " ";
	}
	if ($ChangePasswordAtLogon != "") {
		$COMMAND = $COMMAND . "-ChangePasswordAtLogon " . $ChangePasswordAtLogon . " ";
	}
	if ($City != "") {
		$COMMAND = $COMMAND . "-City " . $City . " ";
	}
	if ($Company != "") {
		$COMMAND = $COMMAND . "-Company " . $Company . " ";
	}
	if ($Country != "") {
		$COMMAND = $COMMAND . "-Country " . $Country . " ";
	}
	if ($Credential != "") {
		$COMMAND = $COMMAND . "-Credential " . $Credential . " ";
	}
	if ($Department != "") {
		$COMMAND = $COMMAND . "-Department " . $Department . " ";
	}
	if ($Description != "") {
		$COMMAND = $COMMAND . "-Description " . $Description . " ";
	}
	if ($DisplayName != "") {
		$COMMAND = $COMMAND . "-DisplayName " . $DisplayName . " ";
	}
	if ($Division != "") {
		$COMMAND = $COMMAND . "-Division " . $Division . " ";
	}
	if ($EmailAddress != "") {
		$COMMAND = $COMMAND . "-EmailAddress " . $EmailAddress . " ";
	}
	if ($EmployeeID != "") {
		$COMMAND = $COMMAND . "-EmployeeID " . $EmployeeID . " ";
	}
	if ($EmployeeNumber != "") {
		$COMMAND = $COMMAND . "-EmployeeNumber " . $EmployeeNumber . " ";
	}
	if ($Enabled != "") {
		$COMMAND = $COMMAND . "-Enabled " . $Enabled . " ";
	}
	if ($Fax != "") {
		$COMMAND = $COMMAND . "-Fax " . $Fax . " ";
	}
	if ($GivenName != "") {
		$COMMAND = $COMMAND . "-GivenName " . $GivenName . " ";
	}
	if ($HomeDirectory != "") {
		$COMMAND = $COMMAND . "-HomeDirectory " . $HomeDirectory . " ";
	}
	if ($HomeDrive != "") {
		$COMMAND = $COMMAND . "-HomeDrive " . $HomeDrive . " ";
	}
	if ($HomePage != "") {
		$COMMAND = $COMMAND . "-HomePage " . $HomePage . " ";
	}
	if ($HomePhone != "") {
		$COMMAND = $COMMAND . "-HomePhone " . $HomePhone . " ";
	}
	if ($Initials != "") {
		$COMMAND = $COMMAND . "-Initials " . $Initials . " ";
	}
	if ($Instance != "") {
		$COMMAND = $COMMAND . "-Instance " . $Instance . " ";
	}
	if ($LogonWorkstations != "") {
		$COMMAND = $COMMAND . "-LogonWorkstations " . $LogonWorkstations . " ";
	}
	if ($Manager != "") {
		$COMMAND = $COMMAND . "-Manager " . $Manager . " ";
	}
	if ($MobilePhone != "") {
		$COMMAND = $COMMAND . "-MobilePhone " . $MobilePhone . " ";
	}
	if ($Office != "") {
		$COMMAND = $COMMAND . "-Office " . $Office . " ";
	}
	if ($OfficePhone != "") {
		$COMMAND = $COMMAND . "-OfficePhone " . $OfficePhone . " ";
	}
	if ($Organization != "") {
		$COMMAND = $COMMAND . "-Organization " . $Organization . " ";
	}
	if ($OtherAttributes != "") {
		$COMMAND = $COMMAND . "-OtherAttributes " . $OtherAttributes . " ";
	}
	if ($OtherName != "") {
		$COMMAND = $COMMAND . "-OtherName " . $OtherName . " ";
	}
	if ($PassThru != "") {
		$COMMAND = $COMMAND . "-PassThru " . $PassThru . " ";
	}
	if ($PasswordNeverExpires != "") {
		$COMMAND = $COMMAND . "-PasswordNeverExpires " . $PasswordNeverExpires . " ";
	}
	if ($PasswordNotRequired != "") {
		$COMMAND = $COMMAND . "-PasswordNotRequired " . $PasswordNotRequired . " ";
	}
	if ($Path != "") {
		$COMMAND = $COMMAND . "-Path " . $Path . " ";
	}
	if ($POBox != "") {
		$COMMAND = $COMMAND . "-POBox " . $POBox . " ";
	}
	if ($PostalCode != "") {
		$COMMAND = $COMMAND . "-PostalCode " . $PostalCode . " ";
	}
	if ($ProfilePath != "") {
		$COMMAND = $COMMAND . "-ProfilePath " . $ProfilePath . " ";
	}
	if ($SamAccountName != "") {
		$COMMAND = $COMMAND . "-SamAccountName " . $SamAccountName . " ";
	}
	if ($ScriptPath != "") {
		$COMMAND = $COMMAND . "-ScriptPath " . $ScriptPath . " ";
	}
	if ($Server != "") {
		$COMMAND = $COMMAND . "-Server " . $Server . " ";
	}
	if ($ServicePrincipalNames != "") {
		$COMMAND = $COMMAND . "-ServicePrincipalNames " . $ServicePrincipalNames . " ";
	}
	if ($SmartcardLogonRequired != "") {
		$COMMAND = $COMMAND . "-SmartcardLogonRequired " . $SmartcardLogonRequired . " ";
	}
	if ($State != "") {
		$COMMAND = $COMMAND . "-State " . $State . " ";
	}
	if ($StreetAddress != "") {
		$COMMAND = $COMMAND . "-StreetAddress " . $StreetAddress . " ";
	}
	if ($Surname != "") {
		$COMMAND = $COMMAND . "-Surname " . $Surname . " ";
	}
	if ($Title != "") {
		$COMMAND = $COMMAND . "-Title " . $Title . " ";
	}
	if ($TrustedForDelegation != "") {
		$COMMAND = $COMMAND . "-TrustedForDelegation " . $TrustedForDelegation . " ";
	}
	if ($Type != "") {
		$COMMAND = $COMMAND . "-Type " . $Type . " ";
	}
	if ($UserPrincipalName != "") {
		$COMMAND = $COMMAND . "-UserPrincipalName " . $UserPrincipalName . " ";
	}
	if ($Confirm != "") {
		$COMMAND = $COMMAND . "-Confirm " . $Confirm . " ";
	}
	if ($WhatIf != "") {
		$COMMAND = $COMMAND . "-WhatIf " . $WhatIf . " ";
	}
	$COMMAND = $COMMAND . "\r\n\r\n";


	// here are some variables that are hard coded. This is the best and easiest way I can think of to do the groups at the moment.
	if ($Group1Name != "") {
		$COMMAND = $COMMAND . "Add-ADGroupMember \"$Group1Name\" %UserName%" . "\r\n\r\n";
	}
	if ($Group2Name != "") {
		$COMMAND = $COMMAND . "Add-ADGroupMember \"$Group2Name\" %UserName%" . "\r\n\r\n";
	}
	if ($Group3Name != "") {
		$COMMAND = $COMMAND . "Add-ADGroupMember \"$Group3Name\" %UserName%" . "\r\n\r\n";
	}
	

	$COMMAND = $COMMAND . "}" . "\r\n";

	

	$sql = "SELECT userID,userImportedID,userAction,userFirstName,userMiddleName,userLastName,userGroup,userUserName,userPassword FROM userDataToImport WHERE $JaneSettingsWHERE AND $ActionCreate = '$ActionCreateText'";
	$result = $link->query($sql);
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			
			//Here is where the custom variables are made. They can come from the DB or be derrived from things in the DB.

			$userID = $row["userID"];
			$StudentID = $row["userImportedID"];
			$Action = $row["userAction"];
			$FirstName = $row["userFirstName"];
			$MiddleName = $row["userMiddleName"];
			$LastName = $row["userLastName"];
			$School = $row["userGroup"];
			$UserName = $row["userUserName"];
			$Password = $row["userPassword"];
			if ($MiddleName != "") {
				$MiddleInitial = substr($MiddleName, 0, 1);
			}



			// Replace variables with corresponding custom data.
                        
			$ThisCOMMAND = $COMMAND;
			$ThisCOMMAND = str_replace("%Action%",$Action,$ThisCOMMAND);
			$ThisCOMMAND = str_replace("%FirstName%",$FirstName,$ThisCOMMAND);
			$ThisCOMMAND = str_replace("%LastName%",$LastName,$ThisCOMMAND);
			$ThisCOMMAND = str_replace("%MiddleInitial%",$MiddleInitial,$ThisCOMMAND);
			$ThisCOMMAND = str_replace("%MiddleName%",$MiddleName,$ThisCOMMAND);
			$ThisCOMMAND = str_replace("%Password%",$Password,$ThisCOMMAND);
			$ThisCOMMAND = str_replace("%School%",$School,$ThisCOMMAND);
			$ThisCOMMAND = str_replace("%StudentID%",$StudentID,$ThisCOMMAND);
			$ThisCOMMAND = str_replace("%UserName%",$UserName,$ThisCOMMAND);

	

			// Write commands for this user, for this setting, to the setting's file.
			$file = $PathToSMBShares . $JaneSettingsNickName . ".ps1";
			if (file_exists($file)) {
				$current = file_get_contents($file);
				$current = $current . $ThisCOMMAND;	
			} else {
				$current = $ThisCOMMAND;
			}
			file_put_contents($file, $current);

		}
	}
}
if ($ActionDisable != "" && $ActionDisableText != "") {
	//make sure user exists first (powershell).
	 $COMMAND = "if (Get-aduser %UserName%)" . "\r\n" . "{" . "\r\n" . "Disable-ADAccount -Identity %UserName%" . "\r\n" . "}" . "\r\n" . "else" . "\r\n" . "{" . "\r\n" . "echo \"This user does not exist.\"" . "\r\n" . "}" . "\r\n";
	$sql = "SELECT userID,userImportedID,userAction,userFirstName,userMiddleName,userLastName,userGroup,userUserName,userPassword FROM userDataToImport WHERE $JaneSettingsWHERE AND $ActionDisable = '$ActionDisableText'";
	$result = $link->query($sql);
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			//Here is where the custom variables are made. They can come from the DB or be derrived from things in the DB.
			$userID = $row["userID"];
			$StudentID = $row["userImportedID"];
			$Action = $row["userAction"];
			$FirstName = $row["userFirstName"];
			$MiddleName = $row["userMiddleName"];
			$LastName = $row["userLastName"];
			$School = $row["userGroup"];
			$UserName = $row["userUserName"];
			$Password = $row["userPassword"];
			if ($MiddleName != "") {
				$MiddleInitial = substr($MiddleName, 0, 1);
			}
			// Replace variables with corresponding custom data.			
			$ThisCOMMAND = $COMMAND;
			$ThisCOMMAND = str_replace("%Action%",$Action,$ThisCOMMAND);
			$ThisCOMMAND = str_replace("%FirstName%",$FirstName,$ThisCOMMAND);
			$ThisCOMMAND = str_replace("%LastName%",$LastName,$ThisCOMMAND);
			$ThisCOMMAND = str_replace("%MiddleInitial%",$MiddleInitial,$ThisCOMMAND);
			$ThisCOMMAND = str_replace("%MiddleName%",$MiddleName,$ThisCOMMAND);
			$ThisCOMMAND = str_replace("%Password%",$Password,$ThisCOMMAND);
			$ThisCOMMAND = str_replace("%School%",$School,$ThisCOMMAND);
			$ThisCOMMAND = str_replace("%StudentID%",$StudentID,$ThisCOMMAND);
			$ThisCOMMAND = str_replace("%UserName%",$UserName,$ThisCOMMAND);
			// Write commands for this user, for this setting, to the setting's file.
			$file = $PathToSMBShares . $JaneSettingsNickName . ".ps1";
			if (file_exists($file)) {
				$current = file_get_contents($file);
				$current = $current . $ThisCOMMAND;
			} else {
				$current = $ThisCOMMAND;
			}
			file_put_contents($file, $current);	
		}
	}
}
if ($ActionDelete != "" && $ActionDeleteText != "") {
	//make sure user exists first (powershell).
         $COMMAND = "if (Get-aduser %UserName%)" . "\r\n" . "{" . "\r\n" . "Remove-ADUser -Identity %UserName%" . "\r\n" . "}" . "\r\n" . "else" . "\r\n" . "{" . "\r\n" . "echo \"This user does not exist.\"" . "\r\n" . "}" . "\r\n";
        $sql = "SELECT userID,userImportedID,userAction,userFirstName,userMiddleName,userLastName,userGroup,userUserName,userPassword FROM userDataToImport WHERE $JaneSettingsWHERE AND $ActionDelete = '$ActionDeleteText'";
        $result = $link->query($sql);
        if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                        //Here is where the custom variables are made. They can come from the DB or be derrived from things in the DB.
                        $userID = $row["userID"];
                        $StudentID = $row["userImportedID"];
                        $Action = $row["userAction"];
                        $FirstName = $row["userFirstName"];
                        $MiddleName = $row["userMiddleName"];
                        $LastName = $row["userLastName"];
                        $School = $row["userGroup"];
                        $UserName = $row["userUserName"];
                        $Password = $row["userPassword"];
                        if ($MiddleName != "") {
                                $MiddleInitial = substr($MiddleName, 0, 1);
                        }
                        // Replace variables with corresponding custom data.
                        $ThisCOMMAND = $COMMAND;
                        $ThisCOMMAND = str_replace("%Action%",$Action,$ThisCOMMAND);
                        $ThisCOMMAND = str_replace("%FirstName%",$FirstName,$ThisCOMMAND);
                        $ThisCOMMAND = str_replace("%LastName%",$LastName,$ThisCOMMAND);
                        $ThisCOMMAND = str_replace("%MiddleInitial%",$MiddleInitial,$ThisCOMMAND);
                        $ThisCOMMAND = str_replace("%MiddleName%",$MiddleName,$ThisCOMMAND);
                        $ThisCOMMAND = str_replace("%Password%",$Password,$ThisCOMMAND);
                        $ThisCOMMAND = str_replace("%School%",$School,$ThisCOMMAND);
                        $ThisCOMMAND = str_replace("%StudentID%",$StudentID,$ThisCOMMAND);
                        $ThisCOMMAND = str_replace("%UserName%",$UserName,$ThisCOMMAND);
                        // Write commands for this user, for this setting, to the setting's file.
                        $file = $PathToSMBShares . $JaneSettingsNickName . ".ps1";
                        if (file_exists($file)) {
                                $current = file_get_contents($file);
                                $current = $current . $ThisCOMMAND;
                        } else {
                                $current = $ThisCOMMAND;
                        }
                        file_put_contents($file, $current);
                }
        }

}
?>
