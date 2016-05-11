<?php
include 'vars.php';
include 'verifysession.php';

if ($SessionIsVerified != "1") {
	$NextURL="login.php";
	header("Location: $NextURL");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<title>Jane</title>


<style>
div{padding:10px;border:5px solid gray;margin:0}
//div{width:600px;padding:10px;border:5px solid gray;margin:0}
</style>


</head>
<body>
<a href="jane.php">Back</a><br>
<form action="janeADPostProcessing.php" method="post">

    <div>
	<font color="red"><b>Jane Settings</b></font><br><br>    



    <span style="color:blue;" title="Settings NickName
            This field is stored in the DB but not used for anything other than reference for users to describe the settings set for these sepcific import settings.">
            Settings NickName
        </span><br>
        <input type="text" name="JaneSettingsNickName" value="<?php echo htmlspecialchars($_SESSION['JaneSettingsNickName']); ?>" readonly></br>
    
<br>

 
<span style="color:blue;" title="Group Name
            This field is stored in the DB but not used for anything other than reference for users to describe the settings set for these sepcific import settings.">
            Group Name
        </span><br>
        <input type="text" name="JaneSettingsGroupName" value="<?php echo htmlspecialchars($_SESSION['JaneSettingsGroupName']); ?>" readonly></br>

<br>



<span style="color:blue;" title="SMB Allowed IP
            This field is stored in the DB but not used for anything other than reference for users to describe the settings set for these sepcific import settings.">
            SMB Allowed IP
        </span><br>
        <input type="text" name="JaneSettingsSMBallowedIP" value="<?php echo htmlspecialchars($_SESSION['JaneSettingsSMBallowedIP']); ?>" readonly></br>

<br>



<span style="color:blue;" title="WHERE
            This is the SQL matching set by Jane's Administrator. 
It determines what data will be selected for import using the below settings.
This field can only be changed by Jane's Administrator.">
            WHERE
        </span><br>
        <input type="text" name="JaneSettingsWHERE" value="<?php echo htmlspecialchars($_SESSION['JaneSettingsWHERE']); ?>" readonly></br>

</div>



<div>
        <span style="color:blue;" title="Actions
            This is where you define what variables cause what actions to occur. You may use one variable for all fields or one variable for each field, or a combination thereof. In Active Directory, the three main actions that Jane is concerened with automating are creating accounts, deleting accounts, and disabling accounts. In order to get this right, you need to communicate with the Jane Administrator about what the variables will contain.

            Example for adding and disabling based on one variable:

            Create when [Action] equals [Add]
            Disable when [Action] equals [Drop]
            Delete when [] equals []

            Note: The only characters allowed in these fields are lowercase and uppercase Alhpha characters, and numeric 0 through 9. All other input will be parsed, never even being stored.">
        Actions
        </span><br>
        Create when <input type="text" name="ActionCreate" value="<?php echo htmlspecialchars($_SESSION['ActionCreate']); ?>"> equals <input type="text" name="ActionCreateText" value="<?php echo ($_SESSION['ActionCreateText']); ?>"></br>
        Disable when <input type="text" name="ActionDisable" value="<?php echo htmlspecialchars($_SESSION['ActionDisable']); ?>"> equals <input type="text" name="ActionDisableText" value="<?php echo ($_SESSION['ActionDisableText']); ?>"></br>
        Delete when <input type="text" name="ActionDelete" value="<?php echo htmlspecialchars($_SESSION['ActionDelete']); ?>"> equals <input type="text" name="ActionDeleteText" value="<?php echo ($_SESSION['ActionDeleteText']); ?>"></br>
    </div>




<div>
<span style="color:blue;" title="Variables
            This is the list of available variables for use in the below settings. These variables are defined by the Jane system administrator and are currently defined in the back-end of the system. You may use these variables anywhere throughout settings (except for actions) as many times as is needed.

            -----Examples-----
            Name:
            &quot;%FirstName% %MiddleName% %LastName%&quot;

            Home Directory:
            &quot;\\server1\userdata\%UserName%&quot;

            Employee Number:
            %ID%

            AccountPassword:
            (ConvertTo-SecureString %Password% -AsPlainText -force)

            Given Name:
            %FirstName%">
        Variables
        </span><br>
<table border="1">
  <tr>
    <th>Variable Names</th>
    <th>Variable Sample Data</th>
  </tr>
<?php
include 'vars.php';
include 'connect2db.php';
if ($SessionIsVerified == 1) {
	$sql = "SELECT VariableName,VariableSample from availableVariables";
	$result = $link->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<tr><td>" . $row['VariableName'] . "</td><td>" . $row['VariableSample'] . "</td</tr>";
		}
	} else {
		echo "<option value='no_users'>no_settings</option>";
	}
}
?>
</table> 
</div>




<div>
        <span style="color:blue;" title="Create Folder for Users
            This option allows you to automate folder creation on a per-user basis.
            There are a few benfits to this, all of them are security related.

            1. This individually sets ACL permissions for the user that the folder is intended
               to belong to. What this means is other users in the domain will not have
               privilages to view other uses folders in a large user share.

            2. This prevents Cryptowall from spreading through various users files by,
               by confining SMB and ACL permissions tightly to each individual user, and
               to other specified users and groups.

            3. You do not need to be a security expert in order to create very secure
               folders and  shares via Jane.">
        Create Folder For Users
        </span><br>
<input type="radio" name="CreateFolder" value="1"<?php if ($_SESSION['CreateFolder'] == 1 ) { echo " checked"; }?>>True<br>
<input type="radio" name="CreateFolder" value="0"<?php if ($_SESSION['CreateFolder'] == 0 ) { echo " checked"; }?>>False<br>
<input type="radio" name="CreateFolder" value=""<?php if ($_SESSION['CreateFolder'] == "" ) { echo " checked"; }?>>Not Specified<br><br>
	If the above setting is enabled, the below fields "Base Directory" and "Folder Name" must be completed.<br><br>
	<span style="color:blue;" title="Base Directory
            This is the directory where folders are to be created.
            For example, C:\HomeDirectories or C:\UserFiles or C:\UserShare$

            Trailing slashes should be excluded.
            This path does not need to previously exist. 
            If the entire path does not exist, it will be created.">
        Base Directory
        </span><br>
	<input type="text" name="BaseDirectory" value="<?php echo htmlspecialchars($_SESSION['BaseDirectory']); ?>"><br>





	<span style="color:blue;" title="Folder Name
            This is the name that will be used for creating the folder, and will also
            be used as the share name if that option is enabled. For example, %UserName%
            or something unique like SouthDivision_%UserName% are acceptable.

            Trailing slashes should be excluded.
            This path does not need to previously exist.
            If the entire path does not exist, it will be created.">
        Folder Name
        </span><br>
        <input type="text" name="FolderName" value="<?php echo htmlspecialchars($_SESSION['FolderName']); ?>"><input type="checkbox" name="ShareThisFolder" value="1" <?php if ($_SESSION['ShareThisFolder'] == "1" ) { echo " checked"; }?>>


	<span style="color:blue;" title="Share This Folder
            The Folder Name is what will be used to create a share folder on a per-user basis, 
            and will also be used as the share name. For example, %UserName% or to make a 
            hidden share, %UserName%$ or something unique like SouthDivision_%UserName%$

            Trailing slashes should be excluded.
            This path does not need to previously exist.
            If the entire path does not exist, it will be created.

            The only account given SMB permission is the user that is being processed.">
        Share This Folder (Per-User)
        </span><br>




	 <span style="color:blue;" title="ACL Permissions
            This is the name that will be used for creating the share folder, and will also be used as the share name.
            For example, %UserName% or to make a hidden share, %UserName%$ or something unique like SouthDivision_%UserName%$
            Each user or group that is specified is given full ACL/UAC rights. It's important to note that these additional
            permissions are not set within SMB.

            Trailing slashes should be excluded. If they are included, they will be truncated.
            This path does not need to previously exist.
            If the directory does not exist, it will be created.">
        ACL Permissions
        </span><br>
	<input type="checkbox" name="aclAdministrators" value="1" <?php if ($_SESSION['aclAdministrators'] == "1" ) { echo " checked"; }?>>Administrators<br>
	<input type="checkbox" name="aclSystem" value="1" <?php if ($_SESSION['aclSystem'] == "1" ) { echo " checked"; }?>>System<br>
	

	<span style="color:blue;" title="Other ACL Permissions
            This field allows you to assign other ACL based permissions.
            Entries may be Account Names, Group names, or a combination thereof.
            Items are comma delimited.

            Example:
            TechsGroup,Visitors,Albert,JoeSmith,jdk1234">
        Other ACL Permissions 
        </span><br>
	<input type="text" name="aclOther" value="<?php echo htmlspecialchars($_SESSION['aclOther']); ?>"></br>
	
	

        <input type="checkbox" name="DisableInheritance" value="1" <?php if ($_SESSION['DisableInheritance'] == "1" ) { echo " checked"; }?>>
	<span style="color:blue;" title="Disable Inheritance
            When this is enabled, inheritance on the user folder is disabled. Generally,
            this is not desired because it causes files and folders created by the user to
            only be accessable by that user only. However, this may be desired in highly
            secure environments so the option is provided here for you.">
        Disable Inheritance
        </span><br>




</div>

<div>
        <span style="color:blue;" title="Group 1 Name
            Specifies a group that users should be placed into after account creation.">
	Group 1 Name
        </span><br>
        <input type="text" name="Group1Name" value="<?php echo htmlspecialchars($_SESSION['Group1Name']); ?>"></br>
    </div>







<div>


        <span style="color:blue;" title="Group 2 Name
            Specifies a group that users should be placed into after account creation.">
            Group 2 Name
        </span><br>
        <input type="text" name="Group2Name" value="<?php echo htmlspecialchars($_SESSION['Group2Name']); ?>"></br>
    </div>





<div>


        <span style="color:blue;" title="Group 3 Name
            Specifies a group that users should be placed into after account creation.">
            Group 3 Name
        </span><br>
        <input type="text" name="Group3Name" value="<?php echo htmlspecialchars($_SESSION['Group3Name']); ?>"></br>
    </div>





<div>


        <span style="color:blue;" title="Remove User From Groups
            Specifies a list of groups that the user should not be in, and should be removed from. Entries are comma delemited.">
            Remove User From Groups
        </span><br>
        <input type="text" name="RemoveFromGroups" value="<?php echo htmlspecialchars($_SESSION['RemoveFromGroups']); ?>"></br>
    </div>




<div>

   
        <span style="color:blue;" title="Name
            Specifies the name of the object. This parameter sets the Name property of the Active Directory object. The LDAP Display Name (ldapDisplayName) of this property is &quot;name&quot;.

            The following example shows how to set this parameter to a name string.
            -Name &quot;SaraDavis&quot;
            Default Value:
            Data Type: string">
            Name
        </span><br>
        <input type="text" name="Name" value="<?php echo htmlspecialchars($_SESSION['Name']); ?>"></br>
    </div>
    <div>
        <span style="color:blue;" title="AccountExpirationDate
            Specifies the expiration date for an account. When you set this parameter to 0, the account never expires. This parameter sets the AccountExpirationDate property of an account object. The LDAP Display name (ldapDisplayName) for this property is accountExpires.

            Use the DateTime syntax when you specify this parameter. Time is assumed to be local time unless otherwise specified. When a time value is not specified, the time is assumed to 12:00:00 AM local time. When a date is not specified, the date is assumed to be the current date. The following examples show commonly-used syntax to specify a DateTime object.
            &quot;4/17/2006&quot;
            &quot;Monday, April 17, 2006&quot;
            &quot;2:22:45 PM&quot;
            &quot;Monday, April 17, 2006 2:22:45 PM&quot;

            These examples specify the same date and the time without the seconds.
            &quot;4/17/2006 2:22 PM&quot;
            &quot;Monday, April 17, 2006 2:22 PM&quot;
            &quot;2:22 PM&quot;

            The following example shows how to specify a date and time by using the RFC1123 standard. This example defines time by using Greenwich Mean Time (GMT).
            &quot;Mon, 17 Apr 2006 21:22:48 GMT&quot;

            The following example shows how to specify a round-trip value as Coordinated Universal Time (UTC). This example represents Monday, April 17, 2006 at 2:22:48 PM UTC.
            &quot;2006-04-17T14:22:48.0000000&quot;

            The following example shows how to set this parameter to the date May 1, 2012 at 5 PM.
            -AccountExpirationDate &quot;05/01/2012 5:00:00 PM&quot;
            Default Value:
            Data Type: System.Nullable[System.DateTime]">
            AccountExpirationDate
        </span><br>
        <input type="text" name="AccountExpirationDate" value="<?php echo htmlspecialchars($_SESSION['AccountExpirationDate']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="AccountNotDelegated
            Specifies whether the security context of the user is delegated to a service. When this parameter is set to true, the security context of the account is not delegated to a service even when the service account is set as trusted for Kerberos delegation. This parameter sets the AccountNotDelegated property for an Active Directory account. This parameter also sets the ADS_UF_NOT_DELEGATED flag of the Active Directory User Account Control (UAC) attribute. Possible values for this parameter include
            $false or 0
            $true or 1

            The following example shows how to set this parameter so that the security context of the account is not delegated to a service.
            -AccountNotDelegated $true
            Default Value:
            Data Type: System.Nullable[bool]">
            AccountNotDelegated
        </span><br>
	<input type="radio" name="AccountNotDelegated" value="1"<?php if ($_SESSION['AccountNotDelegated'] == 1 ) { echo " checked"; }?>>True<br>
        <input type="radio" name="AccountNotDelegated" value="0"<?php if ($_SESSION['AccountNotDelegated'] == 0 ) { echo " checked"; }?>>False<br>
        <input type="radio" name="AccountNotDelegated" value=""<?php if ($_SESSION['AccountNotDelegated'] == "" ) { echo " checked"; }?>>Not Specified<br>


    </div>
    <div>
        <span style="color:blue;" title="AccountPassword
            Specifies a new password value for an account. This value is stored as an encrypted string.

            The following conditions apply based on the manner in which the password parameter is used:

            $null password is specified - No password is set and the account is disabled unless it is requested to be enabled
            No password is specified - No password is set and the account is disabled unless it is requested to be enabled
            User password is specified - Password is set and the account is disabled unless it is requested to be enabled
            Notes:
            User accounts, by default, are created without a password. If you provide a password, an attempt will be made to set that password however, this can fail due to password policy restrictions. The user account will still be created and you may use Set-ADAccountPassword to set the password on that account. In order to ensure that accounts remain secure, user accounts will never be enabled unless a valid password is set or PasswordNotRequired is set to true.
            The account is created if the password fails for any reason.

            The following example shows one method to set this parameter. This command will prompt you to enter the password.
            -AccountPassword (Read-Host -AsSecureString &quot;AccountPassword&quot;)
            Default Value:
            ">
            AccountPassword
        </span><br>
        <input type="text" name="AccountPassword" value="<?php echo htmlspecialchars($_SESSION['AccountPassword']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="AllowReversiblePasswordEncryption
            Specifies whether reversible password encryption is allowed for the account. This parameter sets the AllowReversiblePasswordEncryption property of the account. This parameter also sets the ADS_UF_ENCRYPTED_TEXT_PASSWORD_ALLOWED flag of the Active Directory User Account Control (UAC) attribute. Possible values for this parameter include:
            $false or 0
            $true or 1

            The following example shows how to set this parameter to true.
            -AllowReversiblePasswordEncryption $true
            Default Value:
            Data Type: System.Nullable[bool]">
            AllowReversiblePasswordEncryption
        </span><br>
        <input type="radio" name="AllowReversiblePasswordEncryption" value="1"<?php if ($_SESSION['AllowReversiblePasswordEncryption'] == 1 ) { echo " checked"; }?>>True<br>
        <input type="radio" name="AllowReversiblePasswordEncryption" value="0"<?php if ($_SESSION['AllowReversiblePasswordEncryption'] == 0 ) { echo " checked"; }?>>False<br>
        <input type="radio" name="AllowReversiblePasswordEncryption" value=""<?php if ($_SESSION['AllowReversiblePasswordEncryption'] == "" ) { echo " checked"; }?>>Not Specified<br>
    </div>
    <div>
        <span style="color:blue;" title="AuthType
            Specifies the authentication method to use. Possible values for this parameter include:
            Negotiate or 0
            Basic or 1

            The default authentication method is Negotiate.

            A Secure Sockets Layer (SSL) connection is required for the Basic authentication method.

            The following example shows how to set this parameter to Basic.
            -AuthType Basic
            The following lists the acceptable values for this parameter:
            Negotiate

            Basic

            Default Value: Microsoft.ActiveDirectory.Management.AuthType.Negotiate
            Data Type: ADAuthType">
            AuthType
        </span><br>
        <input type="text" name="AuthType" value="<?php echo htmlspecialchars($_SESSION['AuthType']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="CannotChangePassword
            Specifies whether the account password can be changed. This parameter sets the CannotChangePassword property of an account. Possible values for this parameter include:
            $false or 0
            $true or 1

            The following example shows how to set this parameter so that the account password can be changed.
            -CannotChangePassword $false
            Default Value:
            Data Type: System.Nullable[bool]">
            CannotChangePassword
        </span><br>
        <input type="radio" name="CannotChangePassword" value="1"<?php if ($_SESSION['CannotChangePassword'] == 1 ) { echo " checked"; }?>>True<br>
        <input type="radio" name="CannotChangePassword" value="0"<?php if ($_SESSION['CannotChangePassword'] == 0 ) { echo " checked"; }?>>False<br>
        <input type="radio" name="CannotChangePassword" value=""<?php if ($_SESSION['CannotChangePassword'] == "" ) { echo " checked"; }?>>Not Specified<br>
    </div>
    <div>
        <span style="color:blue;" title="Certificates
            Modifies the DER-encoded X.509v3 certificates of the account. These certificates include the public key certificates issued to this account by the Microsoft Certificate Service. This parameter sets the Certificates property of the account object. The LDAP Display Name (ldapDisplayName) for this property is &quot;userCertificate&quot;.

            Syntax:
            To add values:
            -Certificates @{Add=value1,value2,...}
            To remove values:
            -Certificates @{Remove=value3,value4,...}
            To replace values:
            -Certificates @{Replace=value1,value2,...}
            To clear all values:
            -Certificates $null

            You can specify more than one operation by using a list separated by semicolons. For example, use the following syntax to add and remove Certificate values
            -Certificates @{Add=value1,value2,...};@{Remove=value3,value4,...}

            The operators will be applied in the following sequence:
            ..Remove
            ..Add
            ..Replace

            The following example shows how to create a certificate by using the New-Object cmdlet, and then add it to a user account. When this cmdlet is run, <certificate password> is replaced by the password used to add the certificate.

            $cert = New-Object System.Security.Cryptography.X509Certificates.X509Certificate certificate1.cer <certificate password>
            Set-ADUser saradavis -Certificates @{Add=$cert}

            The following example shows how to add a certificate that is specified as a byte array.
            Set-ADUser saradavis -Certificates @{Add= [Byte[]](0xC5,0xEE,0x53,...)}
            Default Value:
            Data Type: X509Certificate[]">
            Certificates
        </span><br>
        <input type="text" name="Certificates" value="<?php echo htmlspecialchars($_SESSION['Certificates']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="ChangePasswordAtLogon
            Specifies whether a password must be changed during the next logon attempt. Possible values for this parameter include:
            $false or 0
            $true or 1

            This parameter cannot be set to $true or 1 for an account that also has the PasswordNeverExpires property set to true.

            The following example shows how to set this parameter so that the password must be changed at logon.
            -ChangePasswordAtLogon $true
            Default Value:
            Data Type: System.Nullable[bool]">
            ChangePasswordAtLogon
        </span><br>
        <input type="radio" name="ChangePasswordAtLogon" value="1"<?php if ($_SESSION['ChangePasswordAtLogon'] == 1 ) { echo " checked"; }?>>True<br>
        <input type="radio" name="ChangePasswordAtLogon" value="0"<?php if ($_SESSION['ChangePasswordAtLogon'] == 0 ) { echo " checked"; }?>>False<br>
        <input type="radio" name="ChangePasswordAtLogon" value=""<?php if ($_SESSION['ChangePasswordAtLogon'] == "" ) { echo " checked"; }?>>Not Specified<br>
    </div>
    <div>
        <span style="color:blue;" title="City
            Specifies the user's town or city. This parameter sets the City property of a user. The LDAP display name (ldapDisplayName) of this property is &quot;l&quot;.

            The following example shows how set this parameter.
            -City &quot;Las Vegas&quot;
            Default Value:
            Data Type: string">City
        </span><br>
        <input type="text" name="City" value="<?php echo htmlspecialchars($_SESSION['City']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="Company
            Specifies the user's company. This parameter sets the Company property of a user object. The LDAP display name (ldapDisplayName) of this property is &quot;company&quot;.

            The following example shows how to set this parameter.
            -Company &quot;Contoso&quot;
            Default Value:
            Data Type: string">
            Company
        </span><br>
        <input type="text" name="Company" value="<?php echo htmlspecialchars($_SESSION['Company']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="Country
            Specifies the country or region code for the user's language of choice. This parameter sets the Country property of a user object. The LDAP Display Name (ldapDisplayName) of this property is &quot;c&quot;. This value is not used by Windows 2000.

            The following example shows how set this parameter.
            -Country &quot;IN&quot;
            Default Value:
            Data Type: string">
            Country
        </span><br>
        <input type="text" name="Country" value="<?php echo htmlspecialchars($_SESSION['Country']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="Credential
            Specifies the user account credentials to use to perform this task. The default credentials are the credentials of the currently logged on user unless the cmdlet is run from an Active Directory PowerShell provider drive. If the cmdlet is run from such a provider drive, the account associated with the drive is the default.

            To specify this parameter, you can type a user name, such as &quot;User1&quot; or &quot;Domain01\User01&quot; or you can specify a PSCredential object. If you specify a user name for this parameter, the cmdlet prompts for a password.

            You can also create a PSCredential object by using a script or by using the Get-Credential cmdlet. You can then set the Credential parameter to the PSCredential object The following example shows how to create credentials.
            $AdminCredentials = Get-Credential &quot;Domain01\User01&quot;

            The following shows how to set the Credential parameter to these credentials.
            -Credential $AdminCredentials

            If the acting credentials do not have directory-level permission to perform the task, Active Directory PowerShell returns a terminating error.
            Default Value:
            Data Type: PSCredential">
            Credential
        </span><br>
        <input type="text" name="Credential" value="<?php echo htmlspecialchars($_SESSION['Credential']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="Department
            Specifies the user's department. This parameter sets the Department property of a user. The LDAP Display Name (ldapDisplayName) of this property is &quot;department&quot;.

            The following example shows how to set this parameter.
            -Department &quot;Development&quot;
            Default Value:
            Data Type: string">
            Department
        </span><br>
        <input type="text" name="Department" value="<?php echo htmlspecialchars($_SESSION['Department']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="Description
            Specifies a description of the object. This parameter sets the value of the Description property for the object. The LDAP Display Name (ldapDisplayName) for this property is &quot;description&quot;.

            The following example shows how to set this parameter to a sample description.
            -Description &quot;Description of the object&quot;
            Default Value:
            Data Type: string">
            Description
        </span><br>
        <input type="text" name="Description" value="<?php echo htmlspecialchars($_SESSION['Description']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="DisplayName
            Specifies the display name of the object. This parameter sets the DisplayName property of the object. The LDAP Display Name (ldapDisplayName) for this property is &quot;displayName&quot;.

            The following example shows how to set this parameter.
            -DisplayName &quot;Sara Davis Laptop&quot;
            Default Value:
            Data Type: string">
            DisplayName
        </span><br>
        <input type="text" name="DisplayName" value="<?php echo htmlspecialchars($_SESSION['DisplayName']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="Division
            Specifies the user's division. This parameter sets the Division property of a user object. The LDAP Display Name (ldapDisplayName) of this property is &quot;division&quot;.

            The following example shows how to set this parameter.
            -Division &quot;Software&quot;
            Default Value:
            Data Type: string">
            Division
        </span><br>
        <input type="text" name="Division" value="<?php echo htmlspecialchars($_SESSION['Division']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="EmailAddress
            Specifies the user's e-mail address. This parameter sets the EmailAddress property of a user object. The LDAP Display Name (ldapDisplayName) of this property is &quot;mail&quot;.

            The following example shows how to set this parameter.
            -EmailAddress &quot;saradavis@contoso.com&quot;
            Default Value:
            Data Type: string">
            EmailAddress
        </span><br>
        <input type="text" name="EmailAddress" value="<?php echo htmlspecialchars($_SESSION['EmailAddress']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="EmployeeID
            Specifies the user's employee ID. This parameter sets the EmployeeID property of a user object. The LDAP Display Name (ldapDisplayName) of this property is &quot;employeeID&quot;.

            The following example shows how to set this parameter.
            -EmployeeID &quot;A123456&quot;
            Default Value:
            Data Type: string">
            EmployeeID
        </span><br>
        <input type="text" name="EmployeeID" value="<?php echo htmlspecialchars($_SESSION['EmployeeID']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="EmployeeNumber
            Specifies the user's employee number. This parameter sets the EmployeeNumber property of a user object. The LDAP Display Name (ldapDisplayName) of this property is &quot;employeeNumber&quot;.

            The following example shows how set this parameter.
            -EmployeeNumber &quot;12345678&quot;
            Default Value:
            Data Type: string">
            EmployeeNumber
        </span><br>
        <input type="text" name="EmployeeNumber" value="<?php echo htmlspecialchars($_SESSION['EmployeeNumber']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="Enabled
            Specifies if an account is enabled. An enabled account requires a password. This parameter sets the Enabled property for an account object. This parameter also sets the ADS_UF_ACCOUNTDISABLE flag of the Active Directory User Account Control (UAC) attribute. Possible values for this parameter include:
            $false or 0
            $true or 1

            The following example shows how to set this parameter to enable the account.
            -Enabled $true
            Default Value:
            Data Type: System.Nullable[bool]">
            Enabled
        </span><br>
        <input type="radio" name="Enabled" value="1"<?php if ($_SESSION['Enabled'] == 1 ) { echo " checked"; }?>>True<br>
        <input type="radio" name="Enabled" value="0"<?php if ($_SESSION['Enabled'] == 0 ) { echo " checked"; }?>>False<br>
        <input type="radio" name="Enabled" value=""<?php if ($_SESSION['Enabled'] == "" ) { echo " checked"; }?>>Not Specified<br>
    </div>
    <div>
        <span style="color:blue;" title="Fax
            Specifies the user's fax phone number. This parameter sets the Fax property of a user object. The LDAP Display Name (ldapDisplayName) of this property is &quot;facsimileTelephoneNumber&quot;.

            The following example shows how to set this parameter.
            -Fax &quot;+1 (999) 555 1212&quot;
            Default Value:
            Data Type: string">
            Fax
        </span><br>
        <input type="text" name="Fax" value="<?php echo htmlspecialchars($_SESSION['Fax']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="GivenName
            Specifies the user's given name. This parameter sets the GivenName property of a user object. The LDAP Display Name (ldapDisplayName) of this property is &quot;givenName&quot;.

            The following example shows how to set this parameter.
            -givenName &quot;Sanjay&quot;
            Default Value:
            Data Type: string">
            GivenName
        </span><br>
        <input type="text" name="GivenName" value="<?php echo htmlspecialchars($_SESSION['GivenName']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="HomeDirectory
            Specifies a user's home directory. This parameter sets the HomeDirectory property of a user object. The LDAP Display Name (ldapDisplayName) for this property is &quot;homeDirectory&quot;.

            The following example shows how to set this parameter.
            -HomeDirectory &quot;\\users\saraDavisHomeDir&quot;
            Default Value:
            Data Type: string">
            HomeDirectory
        </span><br>
        <input type="text" name="HomeDirectory" value="<?php echo htmlspecialchars($_SESSION['HomeDirectory']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="HomeDrive
            Specifies a drive that is associated with the UNC path defined by the HomeDirectory property. The drive letter is specified as &quot;<DriveLetter>:&quot; where <DriveLetter> indicates the letter of the drive to associate. The <DriveLetter> must be a single, uppercase letter and the colon is required. This parameter sets the HomeDrive property of the user object. The LDAP Display Name (ldapDisplayName) for this property is &quot;homeDrive&quot;.

            The following example shows how to set this parameter.
            -HomeDrive &quot;D:&quot;
            Default Value:
            Data Type: string">
            HomeDrive
        </span><br>
        <input type="text" name="HomeDrive" value="<?php echo htmlspecialchars($_SESSION['HomeDrive']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="HomePage
            Specifies the URL of the home page of the object. This parameter sets the homePage property of an Active Directory object. The LDAP Display Name (ldapDisplayName) for this property is &quot;wWWHomePage&quot;.

            The following example shows how to set this parameter to a URL.
            -HomePage &quot;http://employees.contoso.com/sdavis&quot;
            Default Value:
            Data Type: string">
            HomePage
        </span><br>
        <input type="text" name="HomePage" value="<?php echo htmlspecialchars($_SESSION['HomePage']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="HomePhone
            Specifies the user's home telephone number. This parameter sets the HomePhone property of a user. The LDAP Display Name (ldapDisplayName) of this property is &quot;homePhone&quot;.

            The following example shows how to set this parameter.
            -HomePhone &quot;+1 (999) 555 1212&quot;
            Default Value:
            Data Type: string">
            HomePhone
        </span><br>
        <input type="text" name="HomePhone" value="<?php echo htmlspecialchars($_SESSION['HomePhone']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="Initials
            Specifies the initials that represent part of a user's name. You can use this value for the user's middle initial. This parameter sets the Initials property of a user. The LDAP Display Name (ldapDisplayName) of this property is &quot;initials&quot;.

            The following example shows how set this parameter.
            -Initials &quot;L&quot;
            Default Value:
            Data Type: string">
            Initials
        </span><br>
        <input type="text" name="Initials" value="<?php echo htmlspecialchars($_SESSION['Initials']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="Instance
            Specifies an instance of a user object to use as a template for a new user object.

            You can use an instance of an existing user object as a template or you can construct a new user object for template use. You can construct a new user object using the Windows PowerShell command line or by using a script. The following examples show how to use these two methods to create user object templates.

            Method 1: Use an existing user object as a template for a new object. To retrieve an instance of an existing user object, use a cmdlet such as Get-ADUser. Then provide this object to the Instance parameter of the New-ADUser cmdlet to create a new user object. You can override property values of the new object by setting the appropriate parameters.

            $userInstance = Get-ADUser -Identity &quot;saraDavis&quot;
            New-ADUser -SAMAccountName &quot;ellenAdams&quot; -Instance $userInstance -DisplayName &quot;EllenAdams&quot;

            Method 2: Create a new ADUser object and set the property values by using the Windows PowerShell command line interface. Then pass this object to the Instance parameter of the New-ADUser cmdlet to create the new Active Directory user object.

            $userInstance = new-object Microsoft.ActiveDirectory.Management.ADUser
            $userInstance.DisplayName = &quot;Ellen Adams&quot;
            New-ADUser -SAMAccountName &quot;ellenAdams&quot; -Instance $userInstance

            Note: Specified attributes are not validated, so attempting to set attributes that do not exist or cannot be set will raise an error.
            Default Value:
            Data Type: ADUser">
            Instance
        </span><br>
        <input type="text" name="Instance" value="<?php echo htmlspecialchars($_SESSION['Instance']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="LogonWorkstations
            Specifies the computers that the user can access. To specify more than one computer, create a single comma-separated list. You can identify a computer by using the Security Accounts Manager (SAM) account name (sAMAccountName) or the DNS host name of the computer. The SAM account name is the same as the NetBIOS name of the computer.

            The LDAP display name (ldapDisplayName) for this property is &quot;userWorkStations&quot;.

            The following example shows how to set this parameter by using SAMAccountName (NetBIOS name) and DNSHostName values.
            -LogonWorkstations &quot;saraDavisDesktop,saraDavisLapTop,projectA.corp.contoso.com&quot;
            Default Value:
            Data Type: string">
            LogonWorkstations
        </span><br>
        <input type="text" name="LogonWorkstations" value="<?php echo htmlspecialchars($_SESSION['LogonWorkstations']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="Manager
            Specifies the user's manager. This parameter sets the Manager property of a user. This parameter is set by providing one of the following property values. Note: The identifier in parentheses is the LDAP display name for the property.

            Distinguished Name
            Example: CN=SaraDavis,CN=Europe,CN=Users,DC=corp,DC=contoso,DC=com
            GUID (objectGUID)
            Example: 599c3d2e-f72d-4d20-8a88-030d99495f20
            Security Identifier (objectSid)
            Example: S-1-5-21-3165297888-301567370-576410423-1103
            SAM Account Name (sAMAccountName)
            Example: saradavis

            The LDAP Display Name (ldapDisplayName) of this property is &quot;manager&quot;.

            The following example shows how to set this parameter.
            -Manager saradavis
            Default Value:
            Data Type: ADUser">
            Manager
        </span><br>
        <input type="text" name="Manager" value="<?php echo htmlspecialchars($_SESSION['Manager']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="MobilePhone
            Specifies the user's mobile phone number. This parameter sets the MobilePhone property of a user object. The LDAP Display Name (ldapDisplayName) of this property is &quot;mobile&quot;.

            The following example shows how to set this parameter.
            -MobilePhone &quot;+1 (999 ) 555 1212&quot;
            Default Value:
            Data Type: string
            Attributes">
            MobilePhone
        </span><br>
        <input type="text" name="MobilePhone" value="<?php echo htmlspecialchars($_SESSION['MobilePhone']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="Office
            Specifies the location of the user's office or place of business. This parameter sets the Office property of a user object. The LDAP display name (ldapDisplayName) of this property is &quot;office&quot;.

            The following example shows how to set this parameter.
            -Office &quot;D1042&quot;
            Default Value:
            Data Type: string">
            Office
        </span><br>
        <input type="text" name="Office" value="<?php echo htmlspecialchars($_SESSION['Office']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="OfficePhone
            Specifies the user's office telephone number. This parameter sets the OfficePhone property of a user object. The LDAP display name (ldapDisplayName) of this property is &quot;telephoneNumber&quot;.

            The following example shows how to set this parameter.
            -OfficePhone &quot;+1 (999) 555 1212&quot;
            Default Value:
            Data Type: string">
            OfficePhone
        </span><br>
        <input type="text" name="OfficePhone" value="<?php echo htmlspecialchars($_SESSION['OfficePhone']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="Organization
            Specifies the user's organization. This parameter sets the Organization property of a user object. The LDAP display name (ldapDisplayName) of this property is &quot;o&quot;.

            The following example shows how to set this parameter.
            -Organization &quot;Accounting&quot;
            Default Value:
            Data Type: string">
            Organization
        </span><br>
        <input type="text" name="Organization" value="<?php echo htmlspecialchars($_SESSION['Organization']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="OtherAttributes
            Specifies object attribute values for attributes that are not represented by cmdlet parameters. You can set one or more parameters at the same time with this parameter. If an attribute takes more than one value, you can assign multiple values. To identify an attribute, specify the LDAPDisplayName (ldapDisplayName) defined for it in the Active Directory schema.

            Syntax:
            To specify a single value for an attribute:
            -OtherAttributes @{'AttributeLDAPDisplayName'=value}
            To specify multiple values for an attribute
            -OtherAttributes @{'AttributeLDAPDisplayName'=value1,value2,...}

            You can specify values for more than one attribute by using semicolons to separate attributes. The following syntax shows how to set values for multiple attributes:
            -OtherAttributes @{'Attribute1LDAPDisplayName'=value; 'Attribute2LDAPDisplayName'=value1,value2;...}

            The following examples show how to use this parameter.

            To set the value of a custom attribute called favColors that takes a set of Unicode strings, use the following syntax:
            -OtherAttributes @{'favColors'=&quot;pink&quot;,&quot;purple&quot;}

            To set values for favColors and dateOfBirth simultaneously, use the following syntax:
            -OtherAttributes @{'favColors'=&quot;pink&quot;,&quot;purple&quot;; 'dateOfBirth'=&quot; 01/01/1960&quot;}
            Default Value:
            Data Type: hashtable">
            OtherAttributes
        </span><br>
        <input type="text" name="OtherAttributes" value="<?php echo htmlspecialchars($_SESSION['OtherAttributes']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="OtherName
            Specifies a name in addition to a user's given name and surname, such as the user's middle name. This parameter sets the OtherName property of a user object. The LDAP Display Name (ldapDisplayName) of this property is &quot;middleName&quot;.

            The following example shows how to set this parameter.
            -OtherName &quot;Peter&quot;
            Default Value:
            Data Type: string">
            OtherName
        </span><br>
        <input type="text" name="OtherName" value="<?php echo htmlspecialchars($_SESSION['OtherName']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="PassThru
            Returns the new or modified object. By default (i.e. if -PassThru is not specified), this cmdlet does not generate any output.
            Default Value:
            Data Type: switch">
            PassThru
        </span><br>
        <input type="text" name="PassThru" value="<?php echo htmlspecialchars($_SESSION['PassThru']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="PasswordNeverExpires
            Specifies whether the password of an account can expire. This parameter sets the PasswordNeverExpires property of an account object. This parameter also sets the ADS_UF_DONT_EXPIRE_PASSWD flag of the Active Directory User Account Control attribute. Possible values for this parameter include:
            $false or 0
            $true or 1

            Note: This parameter cannot be set to $true or 1 for an account that also has the ChangePasswordAtLogon property set to true.

            The following example shows how to set this parameter so that the password can expire.
            -PasswordNeverExpires $false
            Default Value:
            Data Type: System.Nullable[bool]">
            PasswordNeverExpires
        </span><br>
        <input type="radio" name="PasswordNeverExpires" value="1"<?php if ($_SESSION['PasswordNeverExpires'] == 1 ) { echo " checked"; }?>>True<br>
        <input type="radio" name="PasswordNeverExpires" value="0"<?php if ($_SESSION['PasswordNeverExpires'] == 0 ) { echo " checked"; }?>>False<br>
        <input type="radio" name="PasswordNeverExpires" value=""<?php if ($_SESSION['PasswordNeverExpires'] == "" ) { echo " checked"; }?>>Not Specified<br>

    </div>
    <div>
        <span style="color:blue;" title="PasswordNotRequired
            Specifies whether the account requires a password. A password is not required for a new account. This parameter sets the PasswordNotRequired property of an account object.

            The following example shows how to set this parameter to true.
            -PasswordNotRequired $true
            Default Value:
            Data Type: System.Nullable[bool]">
            PasswordNotRequired
        </span><br>
        <input type="radio" name="PasswordNotRequired" value="1"<?php if ($_SESSION['PasswordNotRequired'] == 1 ) { echo " checked"; }?>>True<br>
        <input type="radio" name="PasswordNotRequired" value="0"<?php if ($_SESSION['PasswordNotRequired'] == 0 ) { echo " checked"; }?>>False<br>
        <input type="radio" name="PasswordNotRequired" value=""<?php if ($_SESSION['PasswordNotRequired'] == "" ) { echo " checked"; }?>>Not Specified<br>
    </div>
    <div>
        <span style="color:blue;" title="Path
            Specifies the X.500 path of the Organizational Unit (OU) or container where the new object is created.

            In many cases, a default value will be used for the Path parameter if no value is specified. The rules for determining the default value are given below. Note that rules listed first are evaluated first and once a default value can be determined, no further rules will be evaluated.

            In AD DS environments, a default value for Path will be set in the following cases:
            - If the cmdlet is run from an Active Directory PowerShell provider drive, the parameter is set to the current path of the provider drive.
            - If the cmdlet has a default path, this will be used. For example: in New-ADUser, the Path parameter would default to the Users container.
            - If none of the previous cases apply, the default value of Path will be set to the default partition or naming context of the target domain.

            In AD LDS environments, a default value for Path will be set in the following cases:
            - If the cmdlet is run from an Active Directory PowerShell provider drive, the parameter is set to the current path of the provider drive.
            - If the cmdlet has a default path, this will be used. For example: in New-ADUser, the Path parameter would default to the Users container.
            - If the target AD LDS instance has a default naming context, the default value of Path will be set to the default naming context. To specify a default naming context for an AD LDS environment, set the msDS-defaultNamingContext property of the Active Directory directory service agent (DSA) object (nTDSDSA) for the AD LDS instance.
            - If none of the previous cases apply, the Path parameter will not take any default value.

            The following example shows how to set this parameter to an OU.

            -Path &quot;ou=mfg,dc=noam,dc=corp,dc=contoso,dc=com&quot;

            Note: The Active Directory Provider cmdlets, such New-Item, Remove-Item, Remove-ItemProperty, Rename-Item and Set-ItemProperty also contain a Path property. However, for the provider cmdlets, the Path parameter identifies the path of the actual object and not the container as with the Active Directory cmdlets.
            Default Value:
            Data Type: string">
            Path
        </span><br>
        <input type="text" name="Path" value="<?php echo htmlspecialchars($_SESSION['Path']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="POBox
            Specifies the user's post office box number. This parameter sets the POBox property of a user object. The LDAP Display Name (ldapDisplayName) of this property is &quot;postOfficeBox&quot;.

            The following example shows how to set this parameter.
            -POBox &quot;25662&quot;
            Default Value:
            Data Type: string">
            POBox
        </span><br>
        <input type="text" name="POBox" value="<?php echo htmlspecialchars($_SESSION['POBox']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="PostalCode
            Specifies the user's postal code or zip code. This parameter sets the PostalCode property of a user. The LDAP Display Name (ldapDisplayName) of this property is &quot;postalCode&quot;.

            The following example shows how to set this parameter.
            -PostalCode &quot;28712&quot;
            Default Value:
            Data Type: string">
            PostalCode
        </span><br>
        <input type="text" name="PostalCode" value="<?php echo htmlspecialchars($_SESSION['PostalCode']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="ProfilePath
            Specifies a path to the user's profile. This value can be a local absolute path or a Universal Naming Convention (UNC) path. This parameter sets the ProfilePath property of the user object. The LDAP display name (ldapDisplayName) for this property is &quot;profilePath&quot;.

            The following examples show how to set this parameter to a local path and to a UNC path. -ProfilePath " E:\users\profiles\saraDavis" -ProfilePath &quot;\\users\profiles\saraDavis&quot; Default Value: Data Type: string">
            ProfilePath
        </span><br>
        <input type="text" name="ProfilePath" value="<?php echo htmlspecialchars($_SESSION['ProfilePath']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="SamAccountName
            Specifies the Security Account Manager (SAM) account name of the user, group, computer, or service account. The maximum length of the description is 256 characters. To be compatible with older operating systems, create a SAM account name that is 20 characters or less. This parameter sets the SAMAccountName for an account object. The LDAP display name (ldapDisplayName) for this property is &quot;sAMAccountName&quot;.

            The following example shows how to specify this parameter.
            -SAMAccountName &quot;saradavis&quot;

            Note: If the string value provided is not terminated with a '$' character, the system adds one if needed.
            Default Value:
            Data Type: string">
            <font color="red">*</font>SamAccountName
        </span><br>
        <input type="text" name="SamAccountName" value="<?php echo htmlspecialchars($_SESSION['SamAccountName']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="ScriptPath
            Specifies a path to the user's log on script. This value can be a local absolute path or a Universal Naming Convention (UNC) path. This parameter sets the ScriptPath property of the user. The LDAP display name (ldapDisplayName) for this property is &quot;scriptPath&quot;.

            The following example shows how to set this parameter.
            -ScriptPath &quot;\\logonScripts\saradavisLogin&quot;
            Default Value:
            Data Type: string">
            ScriptPath
        </span><br>
        <input type="text" name="ScriptPath" value="<?php echo htmlspecialchars($_SESSION['ScriptPath']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="Server
            Specifies the Active Directory Domain Services instance to connect to, by providing one of the following values for a corresponding domain name or directory server. The service may be any of the following: Active Directory Lightweight Domain Services, Active Directory Domain Services or Active Directory Snapshot instance.
            Domain name values:
            Fully qualified domain name
            Examples: corp.contoso.com
            NetBIOS name
            Example: CORP

            Directory server values:
            Fully qualified directory server name
            Example: corp-DC12.corp.contoso.com
            NetBIOS name
            Example: corp-DC12
            Fully qualified directory server name and port
            Example: corp-DC12.corp.contoso.com:3268

            The default value for the Server parameter is determined by one of the following methods in the order that they are listed:
            -By using Server value from objects passed through the pipeline.
            -By using the server information associated with the Active Directory PowerShell provider drive, when running under that drive.
            -By using the domain of the computer running Powershell.

            The following example shows how to specify a full qualified domain name as the parameter value.
            -Server &quot;corp.contoso.com&quot;
            Default Value:
            Data Type: string">
            Server
        </span><br>
        <input type="text" name="Server" value="<?php echo htmlspecialchars($_SESSION['Server']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="ServicePrincipalNames
            Specifies the service principal names for the account. This parameter sets the ServicePrincipalNames property of the account. The LDAP display name (ldapDisplayName) for this property is servicePrincipalName. This parameter uses the following syntax to add remove, replace or clear service principal name values.
            Syntax:
            To add values:
            -ServicePrincipalNames @{Add=value1,value2,...}
            To remove values:
            -ServicePrincipalNames @{Remove=value3,value4,...}
            To replace values:
            -ServicePrincipalNames @{Replace=value1,value2,...}
            To clear all values:
            -ServicePrincipalNames $null

            You can specify more than one change by using a list separated by semicolons. For example, use the following syntax to add and remove service principal names.
            @{Add=value1,value2,...};@{Remove=value3,value4,...}

            The operators will be applied in the following sequence:
            ..Remove
            ..Add
            ..Replace

            The following example shows how to add and remove service principal names.
            -ServicePrincipalNames-@{Add=&quot;SQLservice\accounting.corp.contoso.com:1456&quot;};{Remove=&quot;SQLservice\finance.corp.contoso.com:1456&quot;}
            Default Value:
            Data Type: string[]">
            ServicePrincipalNames
        </span><br>
        <input type="text" name="ServicePrincipalNames" value="<?php echo htmlspecialchars($_SESSION['ServicePrincipalNames']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="SmartcardLogonRequired
            Specifies whether a smart card is required to logon. This parameter sets the SmartCardLoginRequired property for a user. This parameter also sets the ADS_UF_SMARTCARD_REQUIRED flag of the Active Directory User Account Control attribute. Possible values for this parameter are:
            $false or 0
            $true or 1

            The following example shows how to set this parameter so that a smart card is required to logon to the account.
            -SmartCardLogonRequired $true
            Default Value:
            Data Type: System.Nullable[bool]">
            SmartcardLogonRequired
        </span><br>
        <input type="radio" name="SmartcardLogonRequired" value="1"<?php if ($_SESSION['SmartcardLogonRequired'] == 1 ) { echo " checked"; }?>>True<br>
        <input type="radio" name="SmartcardLogonRequired" value="0"<?php if ($_SESSION['SmartcardLogonRequired'] == 0 ) { echo " checked"; }?>>False<br>
        <input type="radio" name="SmartcardLogonRequired" value=""<?php if ($_SESSION['SmartcardLogonRequired'] == "" ) { echo " checked"; }?>>Not Specified<br>
    </div>
    <div>
        <span style="color:blue;" title="State
            Specifies the user's or Organizational Unit's state or province. This parameter sets the State property of a User or Organizational Unit object. The LDAP display name (ldapDisplayName) of this property is &quot;st&quot;.

            The following example shows how set this parameter.
            -State &quot;Nevada&quot;
            Default Value:
            Data Type: string">
            State
        </span><br>
        <input type="text" name="State" value="<?php echo htmlspecialchars($_SESSION['State']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="StreetAddress
            Specifies the user's street address. This parameter sets the StreetAddress property of a user object. The LDAP display name (ldapDisplayName) of this property is &quot;streetAddress&quot;.

            The following example shows how to set this parameter.
            -StreetAddress &quot;1200 Main Street&quot;
            Default Value:
            Data Type: string">
            StreetAddress
        </span><br>
        <input type="text" name="StreetAddress" value="<?php echo htmlspecialchars($_SESSION['StreetAddress']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="Surname
            Specifies the user's last name or surname. This parameter sets the Surname property of a user object. The LDAP display name (ldapDisplayName) of this property is &quot;sn&quot;.

            The following example shows how to set this parameter.
            -Surname &quot;Patel&quot;
            Default Value:
            Data Type: string">
            Surname
        </span><br>
        <input type="text" name="Surname" value="<?php echo htmlspecialchars($_SESSION['Surname']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="Title
            Specifies the user's title. This parameter sets the Title property of a user object. The LDAP display name (ldapDisplayName) of this property is &quot;title&quot;.

            The following example shows how to set this parameter.
            -Title &quot;Manager&quot;
            Default Value:
            Data Type: string">
            Title
        </span><br>
        <input type="text" name="Title" value="<?php echo htmlspecialchars($_SESSION['Title']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="TrustedForDelegation
            Specifies whether an account is trusted for Kerberos delegation. A service that runs under an account that is trusted for Kerberos delegation can assume the identity of a client requesting the service. This parameter sets the TrustedForDelegation property of an account object. This value also sets the ADS_UF_TRUSTED_FOR_DELEGATION flag of the Active Directory User Account Control attribute. Possible values for this parameter are:
            $false or 0
            $true or 1

            The following example shows how to specify that an account is trusted for Kerberos delegation.
            -TrustedForDelegation $true
            Default Value:
            Data Type: System.Nullable[bool]">
            TrustedForDelegation
        </span><br>
        <input type="radio" name="TrustedForDelegation" value="1"<?php if ($_SESSION['TrustedForDelegation'] == 1 ) { echo " checked"; }?>>True<br>
        <input type="radio" name="TrustedForDelegation" value="0"<?php if ($_SESSION['TrustedForDelegation'] == 0 ) { echo " checked"; }?>>False<br>
        <input type="radio" name="TrustedForDelegation" value=""<?php if ($_SESSION['TrustedForDelegation'] == "" ) { echo " checked"; }?>>Not Specified<br>
    </div>
    <div>
        <span style="color:blue;" title="Type
            Specifies the type of object to create. Set the Type parameter to the LDAP display name of the Active Directory Schema Class that represents the type of object that you want to create. The selected type must be a subclass of the User schema class. If this parameter is not specified it will default to &quot;User&quot;.

            The following example shows how to use this parameter to create a new Active Directory InetOrgPerson object.
            -Type &quot;InetOrgPerson&quot;
            Default Value: user
            Data Type: string">
            Type
        </span><br>
        <input type="text" name="Type" value="<?php echo htmlspecialchars($_SESSION['Type']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="UserPrincipalName
            Each user account has a user principal name (UPN) in the format <user>@<DNS-domain-name>. A UPN is a friendly name assigned by an administrator that is shorter than the LDAP distinguished name used by the system and easier to remember. The UPN is independent of the user object's DN, so a user object can be moved or renamed without affecting the user logon name. When logging on using a UPN, users no longer have to choose a domain from a list on the logon dialog box.
            Default Value:
            Data Type: string">
            UserPrincipalName
        </span><br>
        <input type="text" name="UserPrincipalName" value="<?php echo htmlspecialchars($_SESSION['UserPrincipalName']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="Confirm
            Prompts you for confirmation before executing the command.
            Default Value:
            Data Type: SwitchParameter">
            Confirm
        </span><br>
        <input type="text" name="Confirm" value="<?php echo htmlspecialchars($_SESSION['Confirm']); ?>"><br>
    </div>
    <div>
        <span style="color:blue;" title="WhatIf
            Describes what would happen if you executed the command without actually executing the command.
            Default Value:
            Data Type: SwitchParameter">
            WhatIf
        </span><br>
        <input type="text" name="WhatIf" value="<?php echo htmlspecialchars($_SESSION['WhatIf']); ?>"><br>
    </div>
    <p><p><p>
    <input type="submit" value="Submit">
</form>
</body>
</html>

