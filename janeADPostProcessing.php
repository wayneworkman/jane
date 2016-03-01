<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {



// Escape user inputs for security

$SettingsNickName = $link->real_escape_string($_REQUEST['SettingsNickName']);
$OldSettingsNickName = $SettingsNickName;
$SettingsPassword = $link->real_escape_string($_REQUEST['SettingsPassword']);
$Name = $link->real_escape_string($_REQUEST['Name']);
$AccountExpirationDate = $link->real_escape_string($_REQUEST['AccountExpirationDate']);
$AccountNotDelegated = $link->real_escape_string($_REQUEST['AccountNotDelegated']);
$AccountPassword = $link->real_escape_string($_REQUEST['AccountPassword']);
$Action = $link->real_escape_string($_REQUEST['Action']);
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





// attempt query execution


switch ($Action) {

case "new":

// Encrypt password
$SettingsPassword = password_hash("$SettingsPassword", PASSWORD_DEFAULT);



$sql = "INSERT INTO `janeAD` (`SettingsNickName`, `SettingsPassword`, `Name`, `AccountExpirationDate`, `AccountNotDelegated`, `AccountPassword`, `AllowReversiblePasswordEncryption`, `AuthType`, `CannotChangePassword`, `Certificates`, `ChangePasswordAtLogon`, `City`, `Company`, `Country`, `Credential`, `Department`, `Description`, `DisplayName`, `Division`, `EmailAddress`, `EmployeeID`, `EmployeeNumber`, `Enabled`, `Fax`, `GivenName`, `HomeDirectory`, `HomeDrive`, `HomePage`, `HomePhone`, `Initials`, `Instance`, `LogonWorkstations`, `Manager`, `MobilePhone`, `Office`, `OfficePhone`, `Organization`, `OtherAttributes`, `OtherName`, `PassThru`, `PasswordNeverExpires`, `PasswordNotRequired`, `Path`, `POBox`, `PostalCode`, `ProfilePath`, `SamAccountName`, `ScriptPath`, `Server`, `ServicePrincipalNames`, `SmartcardLogonRequired`, `State`, `StreetAddress`, `Surname`, `Title`, `TrustedForDelegation`, `Type`, `UserPrincipalName`, `Confirm`, `WhatIf`) VALUES ('$SettingsNickName','$SettingsPassword','$Name','$AccountExpirationDate','$AccountNotDelegated','$AccountPassword','$AllowReversiblePasswordEncryption','$AuthType','$CannotChangePassword','$Certificates','$ChangePasswordAtLogon','$City','$Company','$Country','$Credential','$Department','$Description','$DisplayName','$Division','$EmailAddress','$EmployeeID','$EmployeeNumber','$Enabled','$Fax','$GivenName','$HomeDirectory','$HomeDrive','$HomePage','$HomePhone','$Initials','$Instance','$LogonWorkstations','$Manager','$MobilePhone','$Office','$OfficePhone','$Organization','$OtherAttributes','$OtherName','$PassThru','$PasswordNeverExpires','$PasswordNotRequired','$Path','$POBox','$PostalCode','$ProfilePath','$SamAccountName','$ScriptPath','$Server','$ServicePrincipalNames','$SmartcardLogonRequired','$State','$StreetAddress','$Surname','$Title','$TrustedForDelegation','$Type','$UserPrincipalName','$Confirm','$WhatIf');";
break;

case "edit":




// Updating

$sql = "UPDATE `janeAD` SET `SettingsNickName`='$SettingsNickName', `SettingsPassword`='$SettingsPassword', `Name`='$Name', `AccountExpirationDate`='$AccountExpirationDate', `AccountNotDelegated`='$AccountNotDelegated', `AccountPassword`='$AccountPassword', `AllowReversiblePasswordEncryption`='$AllowReversiblePasswordEncryption', `AuthType`='$AuthType', `CannotChangePassword`='$CannotChangePassword', `Certificates`='$Certificates', `ChangePasswordAtLogon`='$ChangePasswordAtLogon', `City`='$City', `Company`='$Company', `Country`='$Country', `Credential`='$Credential', `Department`='$Department', `Description`='$Description', `DisplayName`='$DisplayName', `Division`='$Division', `EmailAddress`='$EmailAddress', `EmployeeID`='$EmployeeID', `EmployeeNumber`='$EmployeeNumber', `Enabled`='$Enabled', `Fax`='$Fax', `GivenName`='$GivenName', `HomeDirectory`='$HomeDirectory', `HomeDrive`='$HomeDrive', `HomePage`='$HomePage', `HomePhone`='$HomePhone', `Initials`='$Initials', `Instance`='$Instance', `LogonWorkstations`='$LogonWorkstations', `Manager`='$Manager', `MobilePhone`='$MobilePhone', `Office`='$Office', `OfficePhone`='$OfficePhone', `Organization`='$Organization', `OtherAttributes`='$OtherAttributes', `OtherName`='$OtherName', `PassThru`='$PassThru', `PasswordNeverExpires`='$PasswordNeverExpires', `PasswordNotRequired`='$PasswordNotRequired', `Path`='$Path', `POBox`='$POBox', `PostalCode`='$PostalCode', `ProfilePath`='$ProfilePath', `SamAccountName`='$SamAccountName', `ScriptPath`='$ScriptPath', `Server`='$Server', `ServicePrincipalNames`='$ServicePrincipalNames', `SmartcardLogonRequired`='$SmartcardLogonRequired', `State`='$State', `StreetAddress`='$StreetAddress', `Surname`='$Surname', `Title`='$Title', `TrustedForDelegation`='$TrustedForDelegation', `Type`='$Type', `UserPrincipalName`='$UserPrincipalName', `Confirm`='$Confirm', `WhatIf`='$WhatIf' WHERE `SettingsNickName` = '$OldSettingsNickName';";




}
?>