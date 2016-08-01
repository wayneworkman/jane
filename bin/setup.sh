#!/bin/bash
cwd="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
source "$cwd/functions.sh"
janeVersion="0.01"
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
setupFirewalld
startAndEnableService "firewalld"
startAndEnableService "httpd"
startAndEnableService "smb"
startAndEnableService "mysql"
startAndEnableService "mariadb"
createUserJane
setupDB
createDirectories
checkCert
setPermissions
setSELinuxToPermissive
startJaneOnBoot
startJaneEngine
completed
