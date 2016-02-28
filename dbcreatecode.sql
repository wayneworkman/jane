#drop user 'jane'@'localhost';
drop database jane;

CREATE DATABASE IF NOT EXISTS jane;

USE jane;

CREATE TABLE userDataToImport(
userID int NOT NULL AUTO_INCREMENT,
userAction VARCHAR(255),
userOrgID VARCHAR(255) UNIQUE,
userFirstName VARCHAR(255),
userMiddleName VARCHAR(255),
userLastName VARCHAR(255),
userGroup VARCHAR(255),
userUserName VARCHAR(255),
userPassword VARCHAR(255),
userMiddleInitial VARCHAR(1),
PRIMARY KEY (userID)
);

CREATE TABLE janeUsers(
JaneUserID int NOT NULL AUTO_INCREMENT,
JaneUsername VARCHAR(255) NOT NULL UNIQUE,
JanePassword VARCHAR(255) NOT NULL,
JaneSMBPassword VARCHAR(255) NOT NULL,
JaneUserEnabled VARCHAR(1) NOT NULL,
PRIMARY KEY (JaneUserID)
);

CREATE TABLE LocalUsersNotToDelete(
SystemUserID int NOT NULL AUTO_INCREMENT,
SystemUsername VARCHAR(255) NOT NULL UNIQUE,
PRIMARY KEY (SystemUserID)
);

CREATE TABLE janeGroups(
JaneGroupID int NOT NULL AUTO_INCREMENT,
JaneGroupName VARCHAR(255) NOT NULL UNIQUE,
PRIMARY KEY (JaneGroupID)
);

CREATE TABLE janeUserGroupAssociation(
uID int NOT NULL,
gID int NOT NULL,
JaneUserGroupAssociationID int NOT NULL AUTO_INCREMENT,
FOREIGN KEY (uID) REFERENCES janeUsers(JaneUserID),
FOREIGN KEY (gID) REFERENCES janeGroups(JaneGroupID),
PRIMARY KEY (JaneUserGroupAssociationID)
);

CREATE TABLE Sessions(
SessionID int NOT NULL AUTO_INCREMENT,
REQUEST_TIME int NOT NULL,
SessionUserID int NOT NULL,
FOREIGN KEY (SessionUserID) REFERENCES janeUsers(JaneUserID),
REMOTE_ADDR VARCHAR(255) NOT NULL,
HTTP_USER_AGENT VARCHAR(255) NOT NULL,
Random_String VARCHAR(8) NOT NULL,
fingerprint VARCHAR(255) NOT NULL UNIQUE,
PRIMARY KEY (SessionID)
);

CREATE UNIQUE INDEX fingerprint_index
ON Sessions (fingerprint);

CREATE TABLE badLoginAttempts(
badLoginID int NOT NULL AUTO_INCREMENT,
badREQUEST_TIME int NOT NULL,
badUsername VARCHAR(255) NOT NULL,
badREMOTE_ADDR VARCHAR(255) NOT NULL,
badHTTP_USER_AGENT VARCHAR(255) NOT NULL,
PRIMARY KEY (badLoginID)
);

CREATE TABLE blockedIPs(
BlockedID int NOT NULL AUTO_INCREMENT,
BlockedIP VARCHAR(255) NOT NULL UNIQUE,
PRIMARY KEY (BlockedID)
);

CREATE UNIQUE INDEX BlockedIP_Indes
ON blockedIPs (BlockedIP);

CREATE TABLE janeSettingsTypes(
SettingsTypeID int NOT NULL AUTO_INCREMENT,
SettingsTypeName VARCHAR(255) NOT NULL UNIQUE,
SettingsTypeDescription VARCHAR(255),
PRIMARY KEY (SettingsTypeID)
);

CREATE TABLE janeSettings(
JaneSettingsID int NOT NULL AUTO_INCREMENT,
JaneSettingsNickName VARCHAR(255) NOT NULL UNIQUE,
JaneSettingsWHERE VARCHAR(255) NOT NULL,
JaneSettingsGroupID int NOT NULL,
FOREIGN KEY (JaneSettingsGroupID) REFERENCES janeGroups(JaneGroupID),
JaneSettingsTypeID int NOT NULL,
FOREIGN KEY (JaneSettingsTypeID) REFERENCES janeSettingsTypes(SettingsTypeID),
JaneSettingsSMBallowedIP VARCHAR(255) NOT NULL,
PRIMARY KEY (JaneSettingsID)
);

CREATE TABLE janeAD(
janeADid int NOT NULL AUTO_INCREMENT,
janeADSettingsID int NOT NULL UNIQUE,
FOREIGN KEY (janeADSettingsID) REFERENCES janeSettings(JaneSettingsID),
Name VARCHAR(255),
AccountExpirationDate VARCHAR(255),
AccountNotDelegated VARCHAR(1),
AccountPassword VARCHAR(255),
AllowReversiblePasswordEncryption VARCHAR(1),
AuthType VARCHAR(255),
CannotChangePassword VARCHAR(1),
Certificates VARCHAR(255),
ChangePasswordAtLogon VARCHAR(1),
City VARCHAR(255),
Company VARCHAR(255),
Country VARCHAR(255),
Credential VARCHAR(255),
Department VARCHAR(255),
Description VARCHAR(255),
DisplayName VARCHAR(255),
Division VARCHAR(255),
EmailAddress VARCHAR(255),
EmployeeID VARCHAR(255),
EmployeeNumber VARCHAR(255),
Enabled VARCHAR(1),
Fax VARCHAR(255),
GivenName VARCHAR(255),
HomeDirectory VARCHAR(255),
HomeDrive VARCHAR(255),
HomePage VARCHAR(255),
HomePhone VARCHAR(255),
Initials VARCHAR(255),
Instance VARCHAR(255),
LogonWorkstations VARCHAR(255),
Manager VARCHAR(255),
MobilePhone VARCHAR(255),
Office VARCHAR(255),
OfficePhone VARCHAR(255),
Organization VARCHAR(255),
OtherAttributes VARCHAR(255),
OtherName VARCHAR(255),
PassThru VARCHAR(255),
PasswordNeverExpires VARCHAR(1),
PasswordNotRequired VARCHAR(1),
Path VARCHAR(255),
POBox VARCHAR(255),
PostalCode VARCHAR(255),
ProfilePath VARCHAR(255),
SamAccountName VARCHAR(255),
ScriptPath VARCHAR(255),
Server VARCHAR(255),
ServicePrincipalNames VARCHAR(255),
SmartcardLogonRequired VARCHAR(1),
State VARCHAR(255),
StreetAddress VARCHAR(255),
Surname VARCHAR(255),
Title VARCHAR(255),
TrustedForDelegation VARCHAR(1),
Type VARCHAR(255),
UserPrincipalName VARCHAR(255),
Confirm VARCHAR(255),
WhatIf VARCHAR(255),
PRIMARY KEY (janeADid)
);

insert into janeUsers (JaneUsername,JanePassword,JaneSMBPassword,JaneUserEnabled) values ('administrator','$2y$10$UivHA1lp.4e7fEDj.C6h9eWCGctGQtV3wlsJqaqTDMTih5ukDTaTi','changeme','1');
#administrator default password  and default SMB password is changeme

insert into janeGroups (JaneGroupName) values ('administrators');

insert into janeUserGroupAssociation (uID,gID) values ((select JaneUserID from janeUsers WHERE JaneUsername = 'administrator'),(select JaneGroupID from janeGroups WHERE JaneGroupName = 'administrators'));


insert into janeUsers (JaneUsername,JanePassword,JaneUserEnabled) values ('tech','$2y$10$UivHA1lp.4e7fEDj.C6h9eWCGctGQtV3wlsJqaqTDMTih5ukDTaTi','1');
#tech default password is changeme

insert into janeGroups (JaneGroupName) values ('techs');

insert into janeUserGroupAssociation (uID,gID) values ((select JaneUserID from janeUsers WHERE JaneUsername = 'tech'),(select JaneGroupID from janeGroups WHERE JaneGroupName = 'techs'));

INSERT INTO janeSettingsTypes (SettingsTypeName,SettingsTypeDescription) VALUES ('Active Directory','Standard Active Directory settings type.');

CREATE USER 'jane'@'localhost' IDENTIFIED BY 'janepassword';

GRANT ALL ON jane.* TO 'jane'@'localhost';



