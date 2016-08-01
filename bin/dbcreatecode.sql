CREATE DATABASE IF NOT EXISTS jane;

USE jane;

CREATE TABLE userDataToImport(
userID int NOT NULL AUTO_INCREMENT,
userImportedID VARCHAR(255),
userAction VARCHAR(255),
userFirstName VARCHAR(255),
userMiddleName VARCHAR(255),
userLastName VARCHAR(255),
userGroup VARCHAR(255),
userUserName VARCHAR(255),
userPassword VARCHAR(255),
PRIMARY KEY (userID)
);

CREATE TABLE availableVariables(
VariableID int NOT NULL AUTO_INCREMENT,
VariableName VARCHAR(255) NOT NULL UNIQUE,
VariableSample VARCHAR(255),
PRIMARY KEY (VariableID)
);

CREATE TABLE janeUsers(
JaneUserID int NOT NULL AUTO_INCREMENT,
JaneUsername VARCHAR(255) NOT NULL UNIQUE,
JanePassword VARCHAR(255) NOT NULL,
JaneSMBPassword VARCHAR(255) NOT NULL,
JaneUserEnabled VARCHAR(1) NOT NULL,
PRIMARY KEY (JaneUserID)
);

CREATE TABLE LocalUsersNotToDisturb(
SystemUserID int NOT NULL AUTO_INCREMENT,
SystemUsername VARCHAR(255) NOT NULL UNIQUE,
PRIMARY KEY (SystemUserID)
);

CREATE TABLE LocalGroupsNotToDisturb(
SystemGroupID int NOT NULL AUTO_INCREMENT,
SystemGroupname VARCHAR(255) NOT NULL UNIQUE,
PRIMARY KEY (SystemGroupID)
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

CREATE TABLE globalSettings(
settingID int NOT NULL AUTO_INCREMENT,
settingKey varchar(255) NOT NULL,
settingDesc longtext,
settingValue varchar(255) NOT NULL,
PRIMARY KEY (settingID)
);

CREATE UNIQUE INDEX BlockedIP_Indes
ON blockedIPs (BlockedIP);

CREATE TABLE janeSettingsTypes(
SettingsTypeID int NOT NULL AUTO_INCREMENT,
SettingsTypeName VARCHAR(255) NOT NULL UNIQUE,
SettingsTypeDescription VARCHAR(255),
SettingsTableName VARCHAR(255) NOT NULL UNIQUE,
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
JaneSettingsID int NOT NULL UNIQUE,
FOREIGN KEY (janeSettingsID) REFERENCES janeSettings(JaneSettingsID),
ActionCreate VARCHAR(255),
ActionDisable VARCHAR(255),
ActionDelete VARCHAR(255),
ActionCreateText VARCHAR(255),
ActionDisableText VARCHAR(255),
ActionDeleteText VARCHAR(255),
Group1Name VARCHAR(255),
Group2Name VARCHAR(255),
Group3Name VarChar(255),
RemoveFromGroups VarChar(255),

CreateFolder VarChar(1),
ShareThisFolder VarChar(1),
DisableInheritance VarChar(1),



CreateShare VarChar(1),
BaseDirectory VarChar(255),
FolderName VarChar(255),
aclAdministrators VarChar(1),
aclSystem VarChar(1),
aclOther VarChar(255),


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
Country VARCHAR(4), #Country in powershell only accepts two characters, but should be enclosed within double quotes.
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
SamAccountName VARCHAR(255) NOT NULL,
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


INSERT INTO globalSettings (settingKey,settingDesc,settingValue) VALUES ('schemaVersion','This is the schema version of the DB. If it is lower than the expected version, conversion automatically happens to bring the DB up to date.','0');


INSERT INTO janeUsers (JaneUsername,JanePassword,JaneSMBPassword,JaneUserEnabled) VALUES ('administrator','$2y$10$UivHA1lp.4e7fEDj.C6h9eWCGctGQtV3wlsJqaqTDMTih5ukDTaTi','changeme','1');
INSERT INTO janeGroups (JaneGroupName) VALUES ('administrators');
INSERT INTO janeUserGroupAssociation (uID,gID) VALUES ((select JaneUserID FROM janeUsers WHERE JaneUsername = 'administrator'),(SELECT JaneGroupID FROM janeGroups WHERE JaneGroupName = 'administrators'));


INSERT INTO janeUsers (JaneUsername,JanePassword,JaneSMBPassword,JaneUserEnabled) VALUES ('tech','$2y$10$UivHA1lp.4e7fEDj.C6h9eWCGctGQtV3wlsJqaqTDMTih5ukDTaTi','changeme','1');
INSERT INTO janeGroups (JaneGroupName) VALUES ('techs');
INSERT INTO janeUserGroupAssociation (uID,gID) VALUES ((SELECT JaneUserID FROM janeUsers WHERE JaneUsername = 'tech'),(SELECT JaneGroupID FROM janeGroups WHERE JaneGroupName = 'techs'));


INSERT INTO janeSettingsTypes (SettingsTypeName,SettingsTypeDescription,SettingsTableName) VALUES ('Active Directory','Standard Active Directory settings type.','janeAD');
INSERT INTO janeSettingsTypes (SettingsTypeName,SettingsTypeDescription,SettingsTableName) VALUES ('OpenDirectory','Standard Open Directory settings type.','janeOD');


INSERT INTO availableVariables (VariableName,VariableSample) VALUES ('%Action%','Add');
INSERT INTO availableVariables (VariableName,VariableSample) VALUES ('%FirstName%','Jane');
INSERT INTO availableVariables (VariableName,VariableSample) VALUES ('%MiddleName%','Marie');
INSERT INTO availableVariables (VariableName,VariableSample) VALUES ('%MiddleInitial%','M');
INSERT INTO availableVariables (VariableName,VariableSample) VALUES ('%LastName%','Smith');
INSERT INTO availableVariables (VariableName,VariableSample) VALUES ('%School%','Mayberry - South HS');
INSERT INTO availableVariables (VariableName,VariableSample) VALUES ('%StudentID%','123456789');
INSERT INTO availableVariables (VariableName,VariableSample) VALUES ('%UserName%','jms6789');
INSERT INTO availableVariables (VariableName,VariableSample) VALUES ('%Password%','05252000');


CREATE USER 'janeWeb'@'localhost' IDENTIFIED BY 'janewebpassword';
CREATE USER 'janeSystem'@'localhost' IDENTIFIED BY 'janesystempassword';


GRANT ALL ON jane.blockedIPs TO 'janeWeb'@'localhost';
GRANT ALL ON jane.Sessions TO 'janeWeb'@'localhost';
GRANT ALL ON jane.badLoginAttempts TO 'janeWeb'@'localhost';
GRANT ALL ON jane.janeAD TO 'janeWeb'@'localhost';
GRANT ALL ON jane.janeGroups TO 'janeWeb'@'localhost';
GRANT ALL ON jane.janeSettings TO 'janeWeb'@'localhost';
GRANT ALL ON jane.janeSettingsTypes TO 'janeWeb'@'localhost';
GRANT ALL ON jane.janeUserGroupAssociation TO 'janeWeb'@'localhost';
GRANT ALL ON jane.janeUsers TO 'janeWeb'@'localhost';
GRANT ALL ON jane.availableVariables TO 'janeWeb'@'localhost';


GRANT ALL ON jane.janeUserGroupAssociation TO 'janeSystem'@'localhost';
GRANT ALL ON jane.janeGroups TO 'janeSystem'@'localhost';
GRANT ALL ON jane.janeUsers TO 'janeSystem'@'localhost';
GRANT ALL ON jane.LocalUsersNotToDisturb TO 'janeSystem'@'localhost';
GRANT ALL ON jane.LocalGroupsNotToDisturb TO 'janeSystem'@'localhost';
GRANT ALL ON jane.janeAD TO 'janeSystem'@'localhost';
GRANT ALL ON jane.janeSettings TO 'janeSystem'@'localhost';
GRANT ALL ON jane.janeSettingsTypes TO 'janeSystem'@'localhost';
GRANT ALL ON jane.userDataToImport TO 'janeSystem'@'localhost';


