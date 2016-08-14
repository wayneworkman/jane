#!/bin/bash
cwd="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
source "$cwd/functions.sh"
source "$cwd/schemaFunctions.sh"
source "$cwd/mysqlCredentials.sh"
janeVersion="0.01"
currentSchemaVersion="4"
banner
checkForRoot
checkOS
installRemiAndEpel
updateServer
checkOrInstallPackage "mariadb" "0"
checkOrInstallPackage "mariadb-server" "0"
checkOrInstallPackage "php" "0"
checkOrInstallPackage "httpd" "0"
checkOrInstallPackage "php-mysqlnd" "0"
checkOrInstallPackage "php-gd" "0"
checkOrInstallPackage "php-mhash" "0"
checkOrInstallPackage "php-mcrypt" "0"
checkOrInstallPackage "samba" "0"
checkOrInstallPackage "samba-client" "0"
checkOrInstallPackage "openssl" "0"
checkOrInstallPackage "firewalld" "0"
checkOrInstallPackage "ntp" "0"
startAndEnableService "firewalld"
setupFirewalld
startAndEnableService "ntpd"
startAndEnableService "httpd"
startAndEnableService "smb"
startAndEnableService "mysql"
createUserJane
setupDB
updateSchema
createDirectories
checkCert
setPermissions
setSELinuxToPermissive
startJaneOnBoot
startJaneEngine
completed
