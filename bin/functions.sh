#!/bin/bash
dots() {
    local pad=$(printf "%0.1s" "."{1..70})
    printf " * %s%*.*s" "$1" 0 $((70-${#1})) "$pad"
    return 0
}
banner() {

clear
echo
echo
echo "        888888                            ";
echo "          \"88b                            ";
echo "           888                            ";
echo "           888  8888b.  88888b.   .d88b.  ";
echo "           888     \"88b 888 \"88b d8P  Y8b ";
echo "           888 .d888888 888  888 88888888 ";
echo "           88P 888  888 888  888 Y8b.     ";
echo "           888 \"Y888888 888  888  \"Y8888  ";
echo "         .d88P                            ";
echo "       .d88P\"                             ";
echo "      888P\"                               ";
echo
echo
echo "   A free and open account provisioning tool."
echo
echo
echo
}
updateServer() {
    dots "Updating server, this could take a while."
    local useYum=$(command -v yum)
    local useDnf=$(command -v dnf)
    if [[ -e "$useDnf" ]]; then
        dnf update -y > /dev/null 2>&1
        [[ $? -eq 0 ]] && echo "Updated" || echo "Failed"
    elif [[ -e "$useYum" ]]; then
        yum update -y > /dev/null 2>&1
        [[ $? -eq 0 ]] && echo "Updated" || echo "Failed"
    else
        echo "Failed"
        return 1
    fi
}
checkOS() {
    dots "Checking for compatible OS"
    if [[ -e "/etc/os-release" ]]; then
        source "/etc/os-release"
        if [[ "$ID" == "centos" || "$ID" == "rhel" || "$ID" == "fedora" ]]; then
            echo "$ID"
        else
            echo "$ID is incompatible"
            exit
        fi
    else
        echo "Could not determine OS"
        exit
    fi
}
installRemiAndEpel() {
    dots "Ensuring Remi and Epel repos are installed"

    local useYum=$(command -v yum)
    local useDnf=$(command -v dnf)

    if [[ "$ID" == "fedora" ]]; then
        if [[ -e "$useDnf" ]]; then
            dnf install http://rpms.remirepo.net/fedora/remi-release-${VERSION_ID}.rpm -y > /dev/null 2>&1
            dnf config-manager --set-enabled remi-php70 > /dev/null 2>&1
            [[ $? -eq 0 ]] && echo "Installed" || echo "Failed"
        elif [[ -e "$useYum" ]]; then
            yum install http://rpms.remirepo.net/fedora/remi-release-${VERSION_ID}.rpm -y > /dev/null 2>&1
            yum config-manager --set-enabled remi-php70 > /dev/null 2>&1
            [[ $? -eq 0 ]] && echo "Installed" || echo "Failed"
        fi
    elif [[ "$ID" == "centos" ]]; then
        if [[ -e "$useDnf" ]]; then
            dnf install https://dl.fedoraproject.org/pub/epel/epel-release-latest-${VERSION_ID}.noarch.rpm -y > /dev/null 2>&1
            dnf install http://rpms.remirepo.net/enterprise/remi-release-${VERSION_ID}.rpm -y > /dev/null 2>&1
            [[ $? -eq 0 ]] && echo "Installed" || echo "Failed"
        elif [[ -e "$useYum" ]]; then
            yum install https://dl.fedoraproject.org/pub/epel/epel-release-latest-${VERSION_ID}.noarch.rpm -y > /dev/null 2>&1
            yum install http://rpms.remirepo.net/enterprise/remi-release-${VERSION_ID}.rpm -y > /dev/null 2>&1
            checkOrInstallPackage "yum-utils" "1"
            yum-config-manager --enable remi-php70 > /dev/null 2>&1
            [[ $? -eq 0 ]] && echo "Installed" || echo "Failed"
        fi
    elif [[ "$ID" == "rhel" ]]; then
        if [[ -e "$useDnf" ]]; then
            dnf install https://dl.fedoraproject.org/pub/epel/epel-release-latest-${VERSION_ID}.noarch.rpm -y > /dev/null 2>&1
            dnf install http://rpms.remirepo.net/enterprise/remi-release-${VERSION_ID}.rpm -y > /dev/null 2>&1
            [[ $? -eq 0 ]] && echo "Installed" || echo "Failed"
        elif [[ -e "$useYum" ]]; then
            yum install https://dl.fedoraproject.org/pub/epel/epel-release-latest-${VERSION_ID}.noarch.rpm -y > /dev/null 2>&1
            yum install http://rpms.remirepo.net/enterprise/remi-release-${VERSION_ID}.rpm -y > /dev/null 2>&1
            checkOrInstallPackage "yum-utils" "1"
            subscription-manager repos --enable=rhel-${VERSION_ID}-server-optional-rpms > /dev/null 2>&1
            yum-config-manager --enable remi-php70 > /dev/null 2>&1
            [[ $? -eq 0 ]] && echo "Installed" || echo "Failed"
        fi
    fi
}
checkOrInstallPackage() {
    local package="$1"
    local silent="$2"
    local packageLocation=""
    if [[ "$silent" -eq 0 ]]; then
        dots "Checking package $package"
    fi
    local packageExists=$(rpm -qa | grep $package)
    if [[ ! -z "$packageExists" ]]; then
        if [[ "$silent" -eq 0 ]]; then
            echo "Already Installed"
        fi
    else
        local useYum=$(command -v yum)
        local useDnf=$(command -v dnf)
        if [[ -e "$useDnf" ]]; then
            dnf install "$package" -y > /dev/null 2>&1
            if [[ "$silent" -eq 0 ]]; then
                [[ $? -eq 0 ]] && echo "Installed" || echo "Failed"
            fi
        elif [[ -e "$useYum" ]]; then
            yum install "$package" -y > /dev/null 2>&1
            if [[ "$silent" -eq 0 ]]; then
                [[ $? -eq 0 ]] && echo "Installed" || echo "Failed"
            fi
        else
            #Unable to determine repo manager.
            if [[ "$silent" -eq 0 ]]; then
                echo "Unable to determine repo manager."
            fi
            return 1
        fi
    fi
}
startAndEnableService() {
    local useSystemctl=$(command -v systemctl)
    local useService=$(command -v service)
    local theService="$1"
    dots "Restarting and enabling $theService"
    if [[ -e "$useSystemctl" ]]; then
        systemctl enable $theService  > /dev/null 2>&1
        systemctl restart $theService > /dev/null 2>&1
        [[ $? -eq 0 ]] && echo "Ok" || echo "Failed"
    elif [[ -e "$useService" ]]; then
        service $theService enable > /dev/null 2>&1
        service $theService restart > /dev/null 2>&1
        [[ $? -eq 0 ]] && echo "Ok" || echo "Failed"
    else
        echo "Unable to determine service manager"
    fi
}
setupFirewalld() {
    dots "Configure firewalld"
    for service in http samba; do firewall-cmd --permanent --zone=public --add-service=$service; done > /dev/null 2>&1
    echo "Done"
}
createUserJane() {
    useradd jane > /dev/null 2>&1
    password=janepassword
    echo -e "$password\n$password\n" | sudo passwd jane > /dev/null 2>&1
    echo -e "$password\n$password\n" | smbpasswd -a jane > /dev/null 2>&1

}
setupDB() {
    dots "Checking for jane database"
    janeDBExists=$(mysql -s -N -e "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'jane'")
    if [[ "$janeDBExists" != "jane" ]]; then
        echo "Does not exist"
        dots "Creating jane database"
        mysql < dbcreatecode.sql > /dev/null 2>&1
        [[ $? -eq 0 ]] && echo "Ok" || echo "Failed"
        dots "Storing existing users and groups"
        php $cwd/../service/initialStoreLocalUsersAndGroups.php  > /dev/null 2>&1
        [[ $? -eq 0 ]] && echo "Ok" || echo "Failed"
    else
        echo "Exists"
    fi
}
createDirectories() {
    dots "Checking and/or Creating directories"
    if [[ ! -d "/jane" ]]; then
        mkdir /jane
    fi
    if [[ ! -d "/jane/imports" ]]; then
        mkdir /jane/imports
    fi
    if [[ ! -d "/jane/ssl" ]]; then
        mkdir /jane/ssl
    fi
    if [[ ! -d "/jane/service" ]]; then
        mkdir /jane/service
        cp -R $cwd/../service /jane
        rm -f /jane/service/initialStoreLocalUsersAndGroups.php
    fi
    if [[ ! -d "/var/www/html/jane" ]]; then
        cp -R $cwd/../jane /var/www/html
    fi
    echo "Done"
}
checkCert() {
    dots "Checking for certificates"
    if [[ ! -e "/jane/ssl/Jane.key" || ! -e "/var/www/html/jane/Jane.crt" ]]; then
        echo "One or both certs missing"
        dots "Creating certs"
        [[ -e "/jane/ssl/Jane.key" ]] && rm -f /jane/ssl/Jane.key
        [[ -e "/var/www/html/jane/Jane.crt" ]] && rm -f /var/www/html/jane/Jane.crt
        openssl req -nodes -x509 -sha256 -newkey rsa:4096 -keyout "/jane/ssl/Jane.key" -out "/var/www/html/jane/Jane.crt" -days 99999 -passin pass:'' -subj "/C=''/ST=''/L=''/O=''/OU=''/CN=''/emailAddress=''"  > /dev/null 2>&1 
        [[ $? -eq 0 ]] && echo "Ok" || echo "Failed"
    else
        echo "Present"
    fi
}
setPermissions() {
    dots "Setting permissions"
    chown -R jane:jane /jane/imports
    chown -R jane:apache /jane/ssl
    chown -R jane:apache /jane/service
    chmod -R 770 /jane
    chown -R apache:apache /var/www/html/jane
    chmod -R 555 /var/www/html/jane
    echo "Done"
}
setSELinuxToPermissive() {
    dots "Setting SELinux to permissive"
    setenforce 0
    sed -i.bak 's/^.*\SELINUX=enforcing\b.*$/SELINUX=permissive/' /etc/selinux/config
    [[ $? -eq 0 ]] && echo "Ok" || echo "Failed"
}
startJaneOnBoot() {
    dots "Enable JaneEngine on boot"
    if [[ -d "/etc/rc.d" ]]; then
        touch /etc/rc.d/rc.local
    else
        echo "No /etc/rc.d directory"
        exit
    fi
    janeEnabled=$(cat /etc/rc.d/rc.local | grep "/usr/bin/nohup /usr/bin/php /jane/service/JaneEngine.php &")    
    if [[ -z $janeEnabled ]]; then
        echo "sleep 30" >> /etc/rc.d/rc.local
        echo "/usr/bin/nohup /usr/bin/php /jane/service/JaneEngine.php &" >> /etc/rc.d/rc.local
        echo "exit 0" >> /etc/rc.d/rc.local
        chmod +x /etc/rc.d/rc.local
        echo "Enabled"
    else
        echo "Already Enabled"
    fi
}
completed() {
echo
echo "Setup complete"
echo
}


