<?php
$sql = "SELECT `JaneSettingsNickName`,`JaneSettingsWHERE`,`JaneSettingsGroupID` FROM `janeSettings` WHERE `JaneSettingsID` = '$JaneSettingsID' LIMIT 1";
$result = $link->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$JaneSettingsNickName = trim($row["JaneSettingsNickName"]);
		$JaneSettingsWHERE = trim($row["JaneSettingsWHERE"]);
		$tmp = trim($row["JaneSettingsGroupID"]);
		$sql = "SELECT `JaneGroupName` FROM `janeGroups` WHERE `JaneGroupID` = $tmp LIMIT 1";
		$result2 = $link->query($sql); if ($result2->num_rows > 0) {
			while($row2 = $result2->fetch_assoc()) {
				$JaneSettingsGroupName = trim($row2["JaneGroupName"]);
			}
		}
		$result2->free();
	}
}
$result->free();



$sql = "SELECT * FROM `janeAD` WHERE `JaneSettingsID` = '$JaneSettingsID' LIMIT 1";
$result = $link->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$ActionCreate = trim($row["ActionCreate"]);
		$ActionDisable = trim($row["ActionDisable"]);
		$ActionDelete = trim($row["ActionDelete"]);
		$ActionCreateText = trim($row["ActionCreateText"]);
		$ActionDisableText = trim($row["ActionDisableText"]);
		$ActionDeleteText = trim($row["ActionDeleteText"]);
		$Group1Name = trim($row["Group1Name"]);
		$Group2Name = trim($row["Group2Name"]);
		$Group3Name = trim($row["Group3Name"]);
		$RemoveFromGroups = trim($row["RemoveFromGroups"]);
		$CreateFolder = trim($row["CreateFolder"]);
		$BaseDirectory = trim($row["BaseDirectory"]);
		$FolderName = trim($row["FolderName"]);
		$ShareThisFolder = trim($row["ShareThisFolder"]);
		$aclAdministrators = trim($row["aclAdministrators"]);
		$aclSystem = trim($row["aclSystem"]);
		$aclOther = trim($row["aclOther"]);
		$DisableInheritance = trim($row["DisableInheritance"]);
		$Name = trim($row["Name"]);
		$AccountExpirationDate = trim($row["AccountExpirationDate"]);
		$AccountNotDelegated = trim($row["AccountNotDelegated"]);
		$AccountPassword = trim($row["AccountPassword"]);
		$AllowReversiblePasswordEncryption = trim($row["AllowReversiblePasswordEncryption"]);
		$AuthType = trim($row["AuthType"]);
		$CannotChangePassword = trim($row["CannotChangePassword"]);
		$Certificates = trim($row["Certificates"]);
		$ChangePasswordAtLogon = trim($row["ChangePasswordAtLogon"]);
		$City = trim($row["City"]);
		$Company = trim($row["Company"]);
		$Country = trim($row["Country"]);
		$Credential = trim($row["Credential"]);
		$Department = trim($row["Department"]);
		$Description = trim($row["Description"]);
		$DisplayName = trim($row["DisplayName"]);
		$Division = trim($row["Division"]);
		$EmailAddress = trim($row["EmailAddress"]);
		$EmployeeID = trim($row["EmployeeID"]);
		$EmployeeNumber = trim($row["EmployeeNumber"]);
		$Enabled = trim($row["Enabled"]);
		$Fax = trim($row["Fax"]);
		$GivenName = trim($row["GivenName"]);
		$HomeDirectory = trim($row["HomeDirectory"]);
		$HomeDrive = trim($row["HomeDrive"]);
		$HomePage = trim($row["HomePage"]);
		$HomePhone = trim($row["HomePhone"]);
		$Initials = trim($row["Initials"]);
		$Instance = trim($row["Instance"]);
		$LogonWorkstations = trim($row["LogonWorkstations"]);
		$Manager = trim($row["Manager"]);
		$MobilePhone = trim($row["MobilePhone"]);
		$Office = trim($row["Office"]);
		$OfficePhone = trim($row["OfficePhone"]);
		$Organization = trim($row["Organization"]);
		$OtherAttributes = trim($row["OtherAttributes"]);
		$OtherName = trim($row["OtherName"]);
		$PassThru = trim($row["PassThru"]);
		$PasswordNeverExpires = trim($row["PasswordNeverExpires"]);
		$PasswordNotRequired = trim($row["PasswordNotRequired"]);
		$Path = trim($row["Path"]);
		$POBox = trim($row["POBox"]);
		$PostalCode = trim($row["PostalCode"]);
		$ProfilePath = trim($row["ProfilePath"]);
		$SamAccountName = trim($row["SamAccountName"]);
		$ScriptPath = trim($row["ScriptPath"]);
		$Server = trim($row["Server"]);
		$ServicePrincipalNames = trim($row["ServicePrincipalNames"]);
		$SmartcardLogonRequired = trim($row["SmartcardLogonRequired"]);
		$State = trim($row["State"]);
		$StreetAddress = trim($row["StreetAddress"]);
		$Surname = trim($row["Surname"]);
		$Title = trim($row["Title"]);
		$TrustedForDelegation = trim($row["TrustedForDelegation"]);
		$Type = trim($row["Type"]);
		$UserPrincipalName = trim($row["UserPrincipalName"]);
		$Confirm = trim($row["Confirm"]);
		$WhatIf = trim($row["WhatIf"]);
	}
} else {
	$ActionCreate = "";
	$ActionDisable = "";
	$ActionDelete = "";
	$ActionCreateText = "";
	$ActionDisableText = "";
	$ActionDeleteText = "";
}

//Put all lines into a single variable to write once at the end instead of for each row.
$PowerShellScript = "";


$file = $PathToSMBShares . "$JaneSettingsGroupName/" . "Created-" . date("Y-m-d---") . $JaneSettingsNickName . ".ps1";



// If there is a file and signature left over, move them.
$sql = "SELECT * FROM `userDataToImport` WHERE $JaneSettingsWHERE LIMIT 1";
	$result = $link->query($sql);
	if ($result->num_rows > 0) {
	//Here, we know there is at least 1 row of data that needs processed. 
	//So we will check for an existing file and move it if it exists.
	//Then process Add, Disable, and Delete, and sign any resultant file.


	if (file_exists($file)) {

		$basename = pathinfo($file,PATHINFO_BASENAME);
		$dirname = pathinfo($file,PATHINFO_DIRNAME);
		$NewFileName = $dirname . "/" . "Renamed-" . date("Y-m-d_h-ia---") . $basename;
		rename ($file, $NewFileName);
	}

	if (file_exists("$file.signed")) {

		$basename = pathinfo("$file.signed",PATHINFO_BASENAME);
		$dirname = pathinfo("$file.signed",PATHINFO_DIRNAME);
		$NewFileName = $dirname . "/" . "Renamed-" . date("Y-m-d_h-ia---") . $basename;
		rename ("$file.signed", $NewFileName);
	}




if ($ActionCreate != "" && $ActionCreateText != "") {
	
	//Echo Date in file.
	$COMMAND = "Get-Date -Format G\r\n";

	//echo system time into comment for record keeping.
	$COMMAND = $COMMAND . "#These commands were written on: " . date("Y/m/d - h:i:sa") . "\r\n";

	//See if the user exists first. If the user does, update it and move it to the right spot. If not, create.
	$COMMAND = $COMMAND . "\$User = Get-ADUser -LDAPFilter \"(sAMAccountName=$SamAccountName)\"\r\n";
	
	$COMMAND = $COMMAND . "if (-Not (\$User -eq \$Null)) {\r\n";
        $COMMAND = $COMMAND . "    echo \"User $SamAccountName already exists, updating it...\"\r\n";
        $COMMAND = $COMMAND . "    Enable-ADAccount -Identity $SamAccountName\r\n";

	 //Here, we move a user to where they should be.
	$COMMAND = $COMMAND . "    echo \"Moving the account to the designated OU.\"\r\n";
	$COMMAND = $COMMAND . "    Get-ADUser -Identity $SamAccountName | Move-ADObject ";

	if ($Path != "") {
		$COMMAND = $COMMAND . "-TargetPath " . $Path . " ";
	}
	if ($AuthType != "") {
		$COMMAND = $COMMAND . "-AuthType " . $AuthType . " ";
	}
	if ($Credential != "") {
		$COMMAND = $COMMAND . "-Credential " . $Credential . " ";
	}
	if ($Server != "") {
		$COMMAND = $COMMAND . "-Server " . $Server . " ";
	}
	$COMMAND = $COMMAND . "\r\n";



	
	//Here, for existing users, update their information according to the settings set.
	$COMMAND = $COMMAND . "    echo \"Updating user information.\"\r\n";
	$COMMAND = $COMMAND . "    Get-ADUser -Identity $SamAccountName | Set-ADUser ";

	if ($AccountExpirationDate != "") {
		$COMMAND = $COMMAND . "-AccountExpirationDate " . $AccountExpirationDate . " ";
	} else {
		$COMMAND = $COMMAND . '-AccountExpirationDate $null ';
	}
	if ($AccountNotDelegated != "") {
		$COMMAND = $COMMAND . "-AccountNotDelegated " . $AccountNotDelegated . " ";
	}
	if ($AllowReversiblePasswordEncryption != "") {
		$COMMAND = $COMMAND . "-AllowReversiblePasswordEncryption " . $AllowReversiblePasswordEncryption . " ";
	} else {
		$COMMAND = $COMMAND . '-AllowReversiblePasswordEncryption $null ';
	}
	if ($AuthType != "") {
		$COMMAND = $COMMAND . "-AuthType " . $AuthType . " ";
	} else {
		$COMMAND = $COMMAND . '-AuthType Negotiate ';
	}
	if ($CannotChangePassword != "") {
		$COMMAND = $COMMAND . "-CannotChangePassword " . $CannotChangePassword . " ";
	} else {
		$COMMAND = $COMMAND . '-CannotChangePassword $null ';
	}
	if ($Certificates != "") {
		$COMMAND = $COMMAND . "-Certificates " . $Certificates . " ";
	} else {
		$COMMAND = $COMMAND . '-Certificates $null ';
	}
	if ($ChangePasswordAtLogon != "") {
		$COMMAND = $COMMAND . "-ChangePasswordAtLogon " . $ChangePasswordAtLogon . " ";
	} else {
		$COMMAND = $COMMAND . '-ChangePasswordAtLogon $null ';
	}
	if ($City != "") {
		$COMMAND = $COMMAND . "-City " . $City . " ";
	} else {
		$COMMAND = $COMMAND . '-City $null ';
	}
	if ($Company != "") {
		$COMMAND = $COMMAND . "-Company " . $Company . " ";
	} else {
		$COMMAND = $COMMAND . '-Company $null ';
	}
	if ($Country != "") {
		$COMMAND = $COMMAND . "-Country " . $Country . " ";
	} else {
		$COMMAND = $COMMAND . '-Country $null ';
	}
	if ($Credential != "") {
		$COMMAND = $COMMAND . "-Credential " . $Credential . " ";
	}
	if ($Department != "") {
		$COMMAND = $COMMAND . "-Department " . $Department . " ";
	} else {
		$COMMAND = $COMMAND . '-Department $null ';
	}
	if ($Description != "") {
		$COMMAND = $COMMAND . "-Description " . $Description . " ";
	} else {
		$COMMAND = $COMMAND . '-Description $null ';
	}
	if ($DisplayName != "") {
		$COMMAND = $COMMAND . "-DisplayName " . $DisplayName . " ";
	} else {
		$COMMAND = $COMMAND . '-DisplayName $null ';
	}
	if ($Division != "") {
		$COMMAND = $COMMAND . "-Division " . $Division . " ";
	} else {
		$COMMAND = $COMMAND . '-Division $null ';
	}
	if ($EmailAddress != "") {
		$COMMAND = $COMMAND . "-EmailAddress " . $EmailAddress . " ";
	} else {
		$COMMAND = $COMMAND . '-EmailAddress $null ';
	}
	if ($EmployeeID != "") {
		$COMMAND = $COMMAND . "-EmployeeID " . $EmployeeID . " ";
	} else {
		$COMMAND = $COMMAND . '-EmployeeID $null ';
	}
	if ($EmployeeNumber != "") {
		$COMMAND = $COMMAND . "-EmployeeNumber " . $EmployeeNumber . " ";
	} else {
		$COMMAND = $COMMAND . '-EmployeeNumber $null ';
	}
	if ($Enabled != "") {
		$COMMAND = $COMMAND . "-Enabled " . $Enabled . " ";
	} else {
		$COMMAND = $COMMAND . '-Enabled $null ';
	}
	if ($Fax != "") {
		$COMMAND = $COMMAND . "-Fax " . $Fax . " ";
	} else {
		$COMMAND = $COMMAND . '-Fax $null ';
	}
	if ($GivenName != "") {
		$COMMAND = $COMMAND . "-GivenName " . $GivenName . " ";
	} else {
		$COMMAND = $COMMAND . '-GivenName $null ';
	}
	if ($HomeDirectory != "") {
		$COMMAND = $COMMAND . "-HomeDirectory " . $HomeDirectory . " ";
	} else {
		$COMMAND = $COMMAND . '-HomeDirectory $null ';
	}
	if ($HomeDrive != "") {
		$COMMAND = $COMMAND . "-HomeDrive " . $HomeDrive . " ";
	} else {
		$COMMAND = $COMMAND . '-HomeDrive $null ';
	}
	if ($HomePage != "") {
		$COMMAND = $COMMAND . "-HomePage " . $HomePage . " ";
	} else {
		$COMMAND = $COMMAND . '-HomePage $null ';
	}
	if ($HomePhone != "") {
		$COMMAND = $COMMAND . "-HomePhone " . $HomePhone . " ";
	} else {
		$COMMAND = $COMMAND . '-HomePhone $null ';
	}
	if ($Initials != "") {
		$COMMAND = $COMMAND . "-Initials " . $Initials . " ";
	} else {
		$COMMAND = $COMMAND . '-Initials $null ';
	}
	if ($LogonWorkstations != "") {
		$COMMAND = $COMMAND . "-LogonWorkstations " . $LogonWorkstations . " ";
	} else {
		$COMMAND = $COMMAND . '-LogonWorkstations $null ';
	}
	if ($Manager != "") {
		$COMMAND = $COMMAND . "-Manager " . $Manager . " ";
	} else {
		$COMMAND = $COMMAND . '-Manager $null ';
	}
	if ($MobilePhone != "") {
		$COMMAND = $COMMAND . "-MobilePhone " . $MobilePhone . " ";
	} else {
		$COMMAND = $COMMAND . '-MobilePhone $null ';
	}
	if ($Office != "") {
		$COMMAND = $COMMAND . "-Office " . $Office . " ";
	} else {
		$COMMAND = $COMMAND . '-Office $null ';
	}
	if ($OfficePhone != "") {
		$COMMAND = $COMMAND . "-OfficePhone " . $OfficePhone . " ";
	} else {
		$COMMAND = $COMMAND . '-OfficePhone $null ';
	}
	if ($Organization != "") {
		$COMMAND = $COMMAND . "-Organization " . $Organization . " ";
	} else {
		$COMMAND = $COMMAND . '-Organization $null ';
	}
	if ($OtherName != "") {
		$COMMAND = $COMMAND . "-OtherName " . $OtherName . " ";
	} else {
		$COMMAND = $COMMAND . '-OtherName $null ';
	}
	if ($PassThru != "") {
		$COMMAND = $COMMAND . "-PassThru " . $PassThru . " ";
	}
	if ($PasswordNeverExpires != "") {
		$COMMAND = $COMMAND . "-PasswordNeverExpires " . $PasswordNeverExpires . " ";
	} else {
		$COMMAND = $COMMAND . '-PasswordNeverExpires $null ';
	}
	if ($PasswordNotRequired != "") {
		$COMMAND = $COMMAND . "-PasswordNotRequired " . $PasswordNotRequired . " ";
	} else {
		$COMMAND = $COMMAND . '-PasswordNotRequired $null ';
	}
	if ($POBox != "") {
		$COMMAND = $COMMAND . "-POBox " . $POBox . " ";
	} else {
		$COMMAND = $COMMAND . '-POBox $null ';
	}
	if ($PostalCode != "") {
		$COMMAND = $COMMAND . "-PostalCode " . $PostalCode . " ";
	} else {
		$COMMAND = $COMMAND . '-PostalCode $null ';
	}
	if ($ProfilePath != "") {
		$COMMAND = $COMMAND . "-ProfilePath " . $ProfilePath . " ";
	} else {
		$COMMAND = $COMMAND . '-ProfilePath $null ';
	}
	if ($SamAccountName != "") {
		$COMMAND = $COMMAND . "-SamAccountName " . $SamAccountName . " ";
	} else {
		$COMMAND = $COMMAND . '-SamAccountName $null ';
	}
	if ($ScriptPath != "") {
		$COMMAND = $COMMAND . "-ScriptPath " . $ScriptPath . " ";
	} else {
		$COMMAND = $COMMAND . '-ScriptPath $null ';
	}
	if ($Server != "") {
		$COMMAND = $COMMAND . "-Server " . $Server . " ";
	} else {
		$COMMAND = $COMMAND . '-Server $null ';
	}
	if ($ServicePrincipalNames != "") {
		$COMMAND = $COMMAND . "-ServicePrincipalNames " . $ServicePrincipalNames . " ";
	} else {
		$COMMAND = $COMMAND . '-ServicePrincipalNames $null ';
	}
	if ($SmartcardLogonRequired != "") {
		$COMMAND = $COMMAND . "-SmartcardLogonRequired " . $SmartcardLogonRequired . " ";
	}
	if ($State != "") {
		$COMMAND = $COMMAND . "-State " . $State . " ";
	} else {
		$COMMAND = $COMMAND . '-State $null ';
	}
	if ($StreetAddress != "") {
		$COMMAND = $COMMAND . "-StreetAddress " . $StreetAddress . " ";
	} else {
		$COMMAND = $COMMAND . '-StreetAddress $null ';
	}
	if ($Surname != "") {
		$COMMAND = $COMMAND . "-Surname " . $Surname . " ";
	} else {
		$COMMAND = $COMMAND . '-Surname $null ';
	}
	if ($Title != "") {
		$COMMAND = $COMMAND . "-Title " . $Title . " ";
	} else {
		$COMMAND = $COMMAND . '-Title $null ';
	}
	if ($TrustedForDelegation != "") {
		$COMMAND = $COMMAND . "-TrustedForDelegation " . $TrustedForDelegation . " ";
	}
	if ($UserPrincipalName != "") {
		$COMMAND = $COMMAND . "-UserPrincipalName " . $UserPrincipalName . " ";
	} else {
		$COMMAND = $COMMAND . '-UserPrincipalName $null ';
	}
	if ($Confirm != "") {
		$COMMAND = $COMMAND . "-Confirm " . $Confirm . " ";
	}
	if ($WhatIf != "") {
		$COMMAND = $COMMAND . "-WhatIf " . $WhatIf . " ";
	}
	$COMMAND = $COMMAND . "\r\n";

	//Add existing users to the user-defined groups.
	// If users are to be added to a group, then the SamAccountName is required.
        if ($Group1Name != "") {
		$COMMAND = $COMMAND . "    echo \"Adding to group 1.\"\r\n";
                $COMMAND = $COMMAND . "    Add-ADGroupMember \"$Group1Name\" $SamAccountName\r\n";
        }
        if ($Group2Name != "") {
		$COMMAND = $COMMAND . "    echo \"Adding to group 2.\"\r\n";
                $COMMAND = $COMMAND . "    Add-ADGroupMember \"$Group2Name\" $SamAccountName\r\n";
        }
        if ($Group3Name != "") {
		$COMMAND = $COMMAND . "    echo \"Adding to group 3.\"\r\n";
                $COMMAND = $COMMAND . "    Add-ADGroupMember \"$Group3Name\" $SamAccountName\r\n";
        }

	//Here, we remove users from groups that they should no longer be in.
	if ($RemoveFromGroups != "") {
		$GroupsToRemoveFrom = explode(",", $RemoveFromGroups);
		foreach ($GroupsToRemoveFrom as $GroupToRemoveFrom) {
			$COMMAND = $COMMAND . "    echo \"Removing from group.\"\r\n";
			$COMMAND = $COMMAND . "    Remove-ADGroupMember \"$GroupToRemoveFrom\" $SamAccountName -Confirm:\$false\r\n";
		}
	}






	//Here, we create a folder if folder creation is set.
	if ($CreateFolder == 1) {
		$COMMAND = $COMMAND . "    echo \"Creating directory for folder\"\r\n";
		$COMMAND = $COMMAND . "    New-Item \"$BaseDirectory\\$FolderName\" -type directory -Force\r\n";
		

		if ($ShareThisFolder == 1) {
			$COMMAND = $COMMAND . "    echo \"Setting sharing.\"\r\n";
			$COMMAND = $COMMAND . "    New-SMBShare -Name \"$FolderName\" -Path \"$BaseDirectory\\$FolderName\" -FullAccess $SamAccountName\r\n";
		}

		// Common settings every folder gets go here.
		$COMMAND = $COMMAND . "    echo \"Setting user's permissions on folder.\"\r\n";
		$COMMAND = $COMMAND . "    \$acl = New-Object System.Security.AccessControl.DirectorySecurity\r\n";
		$COMMAND = $COMMAND . "    \$permission = \"$SamAccountName\",\"FullControl\",\"Allow\"\r\n";
		$COMMAND = $COMMAND . "    \$accessRule = New-Object System.Security.AccessControl.FileSystemAccessRule \$permission\r\n";
		$COMMAND = $COMMAND . "    \$acl.SetAccessRule(\$accessRule)\r\n";

		if ($aclAdministrators == 1) {
			$COMMAND = $COMMAND . "    echo \"Setting Administrators to acl.\"\r\n";
			$COMMAND = $COMMAND . "    \$permission = \"Administrators\",\"FullControl\",\"Allow\"\r\n";
			$COMMAND = $COMMAND . "    \$accessRule = New-Object System.Security.AccessControl.FileSystemAccessRule \$permission\r\n";
			$COMMAND = $COMMAND . "    \$acl.SetAccessRule(\$accessRule)\r\n";
		}

		if ($aclSystem == 1) {
			$COMMAND = $COMMAND . "    echo \"Setting System to acl.\"\r\n";
			$COMMAND = $COMMAND . "    \$permission = \"System\",\"FullControl\",\"Allow\"\r\n";
			$COMMAND = $COMMAND . "    \$accessRule = New-Object System.Security.AccessControl.FileSystemAccessRule \$permission\r\n";
			$COMMAND = $COMMAND . "    \$acl.SetAccessRule(\$accessRule)\r\n";
		}

		if ($aclOther != "") {
			$OtherAcls = explode(",", $aclOther);
			foreach ($OtherAcls as $OtherAcl) {
				$COMMAND = $COMMAND . "    echo \"Adding other acl permissions.\"\r\n";
				$COMMAND = $COMMAND . "    \$permission = \"$OtherAcl\",\"FullControl\",\"Allow\"\r\n";
				$COMMAND = $COMMAND . "    \$accessRule = New-Object System.Security.AccessControl.FileSystemAccessRule \$permission\r\n";
				$COMMAND = $COMMAND . "    \$acl.SetAccessRule(\$accessRule)\r\n";
			}
		}

		if ($DisableInheritance == 1) {
			$COMMAND = $COMMAND . "    echo \"Removing inheritance from acl.\"\r\n";
			$COMMAND = $COMMAND . "    \$acl.SetAccessRuleProtection(\$True, \$True)\r\n";
		}

		$COMMAND = $COMMAND . "    echo \"Applying acl to the new share.\"\r\n";
		$COMMAND = $COMMAND . "    \$acl | Set-Acl $BaseDirectory\\$FolderName\r\n";
		

	}



	$COMMAND = $COMMAND . "} else {" . "\r\n";
	

$COMMAND = $COMMAND . "    echo \"User $SamAccountName does not exist, Creating it.\"\r\n";
	$COMMAND = $COMMAND . "    New-ADUser ";
	
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
	$COMMAND = $COMMAND . "\r\n";


	//Add existing users to the user-defined groups.
	// If users are to be added to a group, then the SamAccountName is required.
        if ($Group1Name != "") {
		$COMMAND = $COMMAND . "    echo \"Adding to group 1.\"\r\n";
                $COMMAND = $COMMAND . "    Add-ADGroupMember \"$Group1Name\" $SamAccountName\r\n";
        }
        if ($Group2Name != "") {
		$COMMAND = $COMMAND . "    echo \"Adding to group 2.\"\r\n";
                $COMMAND = $COMMAND . "    Add-ADGroupMember \"$Group2Name\" $SamAccountName\r\n";
        }
        if ($Group3Name != "") {
		$COMMAND = $COMMAND . "    echo \"Adding to group 3.\"\r\n";
                $COMMAND = $COMMAND . "    Add-ADGroupMember \"$Group3Name\" $SamAccountName\r\n";
        }

	//Here, we remove users from groups that they should no longer be in.
	if ($RemoveFromGroups != "") {
		$GroupsToRemoveFrom = explode(",", $RemoveFromGroups);
		foreach ($GroupsToRemoveFrom as $GroupToRemoveFrom) {
			$COMMAND = $COMMAND . "    echo \"Removing from group.\"\r\n";
			$COMMAND = $COMMAND . "    Remove-ADGroupMember \"$GroupToRemoveFrom\" $SamAccountName -Confirm:\$false\r\n";
		}
	}



	//Here, we create a folder if folder creation is set.
	if ($CreateFolder == 1) {
		$COMMAND = $COMMAND . "    echo \"Creating directory for folder\"\r\n";
		$COMMAND = $COMMAND . "    New-Item \"$BaseDirectory\\$FolderName\" -type directory -Force\r\n";
		

		if ($ShareThisFolder == 1) {
			$COMMAND = $COMMAND . "    echo \"Setting sharing.\"\r\n";
			$COMMAND = $COMMAND . "    New-SMBShare -Name \"$FolderName\" -Path \"$BaseDirectory\\$FolderName\" -FullAccess $SamAccountName\r\n";
		}

		// Permissions that every folder gets go here.
		$COMMAND = $COMMAND . "    echo \"Setting user's permissions on folder.\"\r\n";
		$COMMAND = $COMMAND . "    \$acl = New-Object System.Security.AccessControl.DirectorySecurity\r\n";
		$COMMAND = $COMMAND . "    \$permission = \"$SamAccountName\",\"FullControl\",\"Allow\"\r\n";
		$COMMAND = $COMMAND . "    \$accessRule = New-Object System.Security.AccessControl.FileSystemAccessRule \$permission\r\n";
		$COMMAND = $COMMAND . "    \$acl.SetAccessRule(\$accessRule)\r\n";

		if ($aclAdministrators == 1) {
			$COMMAND = $COMMAND . "    echo \"Setting Administrators to acl.\"\r\n";
			$COMMAND = $COMMAND . "    \$permission = \"Administrators\",\"FullControl\",\"Allow\"\r\n";
			$COMMAND = $COMMAND . "    \$accessRule = New-Object System.Security.AccessControl.FileSystemAccessRule \$permission\r\n";
			$COMMAND = $COMMAND . "    \$acl.SetAccessRule(\$accessRule)\r\n";
		}

		if ($aclSystem == 1) {
			$COMMAND = $COMMAND . "    echo \"Setting System to acl.\"\r\n";
			$COMMAND = $COMMAND . "    \$permission = \"System\",\"FullControl\",\"Allow\"\r\n";
			$COMMAND = $COMMAND . "    \$accessRule = New-Object System.Security.AccessControl.FileSystemAccessRule \$permission\r\n";
			$COMMAND = $COMMAND . "    \$acl.SetAccessRule(\$accessRule)\r\n";
		}

		if ($aclOther != "") {
			$OtherAcls = explode(",", $aclOther);
			foreach ($OtherAcls as $OtherAcl) {
				$COMMAND = $COMMAND . "    echo \"Adding other acl permissions.\"\r\n";
				$COMMAND = $COMMAND . "    \$permission = \"$OtherAcl\",\"FullControl\",\"Allow\"\r\n";
				$COMMAND = $COMMAND . "    \$accessRule = New-Object System.Security.AccessControl.FileSystemAccessRule \$permission\r\n";
				$COMMAND = $COMMAND . "    \$acl.SetAccessRule(\$accessRule)\r\n";
			}
		}

		if ($DisableInheritance == 1) {
			$COMMAND = $COMMAND . "    echo \"Removing inheritance from acl.\"\r\n";
			$COMMAND = $COMMAND . "    \$acl.SetAccessRuleProtection(\$True, \$True)\r\n";
		}

		$COMMAND = $COMMAND . "    echo \"Applying acl to the new share.\"\r\n";
		$COMMAND = $COMMAND . "    \$acl | Set-Acl $BaseDirectory\\$FolderName\r\n";
		

	}



	

	$COMMAND = $COMMAND . "}" . "\r\n";

	

	$sql = "SELECT `userID`,`userImportedID`,`userAction`,`userFirstName`,`userMiddleName`,`userLastName`,`userGroup`,`userUserName`,`userPassword` FROM `userDataToImport` WHERE $JaneSettingsWHERE AND $ActionCreate = '$ActionCreateText'";
	$result = $link->query($sql);
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			
			//Here is where the custom variables are made. They can come from the DB or be derrived from things in the DB.

			$userID = trim($row["userID"]);
			$StudentID = trim($row["userImportedID"]);
			$Action = trim($row["userAction"]);
			$FirstName = trim($row["userFirstName"]);
			$MiddleName = trim($row["userMiddleName"]);
			$LastName = trim($row["userLastName"]);
			$School = trim($row["userGroup"]);
			$UserName = trim($row["userUserName"]);
			$Password = trim($row["userPassword"]);
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
			if (file_exists($file)) {
				$current = file_get_contents($file);
				$current = $current . $ThisCOMMAND;	
			} else {
				$current = $ThisCOMMAND;
			}
			$PowerShellScript .= $current
		}
		file_put_contents($file, $PowerShellScript);
		$PowerShellScript = "";
	}
}
if ($ActionDisable != "" && $ActionDisableText != "") {


	// Echo date.
	$COMMAND = "Get-Date -Format G\r\n";


	//echo system time into comment for record keeping.
	$COMMAND = $COMMAND . "#These commands were written on: " . date("Y/m/d - h:i:sa") . "\r\n";

	//make sure user exists first (powershell).
	 $COMMAND = $COMMAND . "if (Get-aduser $SamAccountName) {\r\n    echo \"Disabling user $SamAccountName.\"\r\n    Disable-ADAccount -Identity $SamAccountName\r\n} else {\r\n    echo \"This user does not exist.\"\r\n}\r\n";
	$sql = "SELECT `userID`,`userImportedID`,`userAction`,`userFirstName`,`userMiddleName`,`userLastName`,`userGroup`,`userUserName`,`userPassword` FROM `userDataToImport` WHERE $JaneSettingsWHERE AND $ActionDisable = '$ActionDisableText'";
	$result = $link->query($sql);
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			//Here is where the custom variables are made. They can come from the DB or be derrived from things in the DB.
			$userID = trim($row["userID"]);
			$StudentID = trim($row["userImportedID"]);
			$Action = trim($row["userAction"]);
			$FirstName = trim($row["userFirstName"]);
			$MiddleName = trim($row["userMiddleName"]);
			$LastName = trim($row["userLastName"]);
			$School = trim($row["userGroup"]);
			$UserName = trim($row["userUserName"]);
			$Password = trim($row["userPassword"]);
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
			if (file_exists($file)) {
				$current = file_get_contents($file);
				$current = $current . $ThisCOMMAND;
			} else {
				$current = $ThisCOMMAND;
			}
			$PowerShellScript .= $current
		}
		file_put_contents($file, $PowerShellScript);
		$PowerShellScript = "";
	}
}
if ($ActionDelete != "" && $ActionDeleteText != "") {
	
	// Echo date.
	$COMMAND = "Get-Date -Format G\r\n";

	//echo system time into comment for record keeping.
	$COMMAND = $COMMAND . "#These commands were written on: " . date("Y/m/d - h:i:sa") . "\r\n";

	//make sure user exists first (powershell).
         $COMMAND = $COMMAND . "if (Get-aduser $SamAccountName) {\r\n    echo \"Deleting user $SamAccountName\"\r\n    Remove-ADUser -Identity $SamAccountName\r\n} else {\r\n    echo \"This user does not exist.\"\r\n}\r\n";
        $sql = "SELECT `userID`,`userImportedID`,`userAction`,`userFirstName`,`userMiddleName`,`userLastName`,`userGroup`,`userUserName`,`userPassword` FROM `userDataToImport` WHERE $JaneSettingsWHERE AND $ActionDelete = '$ActionDeleteText'";
        $result = $link->query($sql);
        if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                        //Here is where the custom variables are made. They can come from the DB or be derrived from things in the DB.
                        $userID = trim($row["userID"]);
                        $StudentID = trim($row["userImportedID"]);
                        $Action = trim($row["userAction"]);
                        $FirstName = trim($row["userFirstName"]);
                        $MiddleName = trim($row["userMiddleName"]);
                        $LastName = trim($row["userLastName"]);
                        $School = trim($row["userGroup"]);
                        $UserName = trim($row["userUserName"]);
                        $Password = trim($row["userPassword"]);
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
                        if (file_exists($file)) {
                                $current = file_get_contents($file);
                                $current = $current . $ThisCOMMAND;
                        } else {
                                $current = $ThisCOMMAND;
                        }
			$PowerShellScript .= $current
                }
		file_put_contents($file, $PowerShellScript);
		$PowerShellScript = "";
	}
}
unset($PowerShellScript);


// Sign the resultant script, if it exists, and if the private key exists.
if (file_exists($file) && file_exists($PrivateKey)) {
	exec("openssl dgst -sha256 -sign \"$PrivateKey\" -out $file.signed $file > /dev/null");
}

}

?>
