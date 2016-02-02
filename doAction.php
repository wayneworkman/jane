<?php
include 'vars.php';
// Escape user inputs for security

$SettingsNickName = mysql_real_escape_string($_REQUEST['SettingsNickName']);
$SettingsPassword = mysql_real_escape_string($_REQUEST['SettingsPassword']);
$Action = mysql_real_escape_string($_REQUEST['Action']);
$NewSettingType = mysql_real_escape_string($_REQUEST['NewSettingType']);






switch ($Action) {

case "edit":

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */


// Create connection
$link = new mysqli($servername, $username, $password, $database);

// Check connection
if ($link->connect_error) die("Connection failed: $link->connect_error");

$sql = "SELECT SettingsPassword FROM janeAD WHERE SettingsNickName = '$SettingsNickName' LIMIT 1";

$result = $link->query($sql);
$StoredPassword = "";

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $StoredPassword = $row["SettingsPassword"];
    }
} else {
    echo "0 results";
}



if (password_verify($SettingsPassword, $StoredPassword)) {
$SettingsPassword = password_hash("$SettingsPassword", PASSWORD_DEFAULT);



$sql = "SELECT * FROM janeAD WHERE SettingsNickName = '$SettingsNickName' LIMIT 1";

$result = $link->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        
	
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
$link->close();


$NextURL = "adSetSettings.php?SettingsNickName=$SettingsNickName&SettingsPassword=$SettingsPassword&Name=$Name&AccountExpirationDate=$AccountExpirationDate&AccountNotDelegated=$AccountNotDelegated&AccountPassword=$AccountPassword&Action=$Action&AllowReversiblePasswordEncryption=$AllowReversiblePasswordEncryption&AuthType=$AuthType&CannotChangePassword=$CannotChangePassword&Certificates=$Certificates&ChangePasswordAtLogon=$ChangePasswordAtLogon&City=$City&Company=$Company&Country=$Country&Credential=$Credential&Department=$Department&Description=$Description&DisplayName=$DisplayName&Division=$Division&EmailAddress=$EmailAddress&EmployeeID=$EmployeeID&EmployeeNumber=$EmployeeNumber&Enabled=$Enabled&Fax=$Fax&GivenName=$GivenName&HomeDirectory=$HomeDirectory&HomeDrive=$HomeDrive&HomePage=$HomePage&HomePhone=$HomePhone&Initials=$Initials&Instance=$Instance&LogonWorkstations=$LogonWorkstations&Manager=$Manager&MobilePhone=$MobilePhone&Office=$Office&OfficePhone=$OfficePhone&Organization=$Organization&OtherAttributes=$OtherAttributes&OtherName=$OtherName&PassThru=$PassThru&PasswordNeverExpires=$PasswordNeverExpires&PasswordNotRequired=$PasswordNotRequired&Path=$Path&POBox=$POBox&PostalCode=$PostalCode&ProfilePath=$ProfilePath&SamAccountName=$SamAccountName&ScriptPath=$ScriptPath&Server=$Server&ServicePrincipalNames=$ServicePrincipalNames&SmartcardLogonRequired=$SmartcardLogonRequired&State=$State&StreetAddress=$StreetAddress&Surname=$Surname&Title=$Title&TrustedForDelegation=$TrustedForDelegation&Type=$Type&UserPrincipalName=$UserPrincipalName&Confirm=$Confirm&WhatIf=$WhatIf";

header("Location: $NextURL");

	
} else {
    echo "0 results";
$link->close();
}



} else {

echo "Passwords_Do_Not_Match";
$link->close();
}


break;

case "delete":

/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */




// Create connection
$link = new mysqli($servername, $username, $password, $database);

// Check connection
if ($link->connect_error) die("Connection failed: $link->connect_error");

$sql = "SELECT SettingsPassword FROM janeAD WHERE SettingsNickName = '$SettingsNickName' LIMIT 1";

$result = $link->query($sql);
$StoredPassword = "";

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $StoredPassword = $row["SettingsPassword"];
    }
} else {
    echo "0 results";
}


if (password_verify($SettingsPassword, $StoredPassword)) {


$sql = "DELETE FROM janeAD WHERE SettingsNickName = '$SettingsNickName'";

if ($link->query($sql) === TRUE) {
    echo "Record deleted successfully<br>";
	echo '<a href="jane.php">Return</a>';

} else {
    echo "Error deleting record: " . $link->error;
}

$link->close();


} else {
echo "Passwords don't match.";
}




break;
case "new":

$NextURL = "adSetSettings.php?Action=$Action";

header("Location: $NextURL");

break;
default:
echo "Something has gone wrong. Options were not passed correctly from jane.php";


break;
}


?>

