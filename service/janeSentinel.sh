#!/bin/bash

#Check if JaneEngine is running.
#Check if log file exists.

ps=$(command -v ps)
grep=$(command -v grep)
echo=$(command -v echo)
nohup=$(command -v nohup)
php=$(command -v php)
janeEngine="/jane/service/JaneEngine.php"
log="/jane/log/JaneEngine.log"
systemctl=$(command -v systemctl)
pkill=$(command -v pkill)
reboot=$(command -v reboot)
sleep=$(command -v sleep)
touch=$(command -v touch)
mkdir=$(command -v mkdir)
rebootWait="1800" #Default is 30 minutes, 1800 seconds.
date=$(command -v date)

#Check to see if the log file exists or not.
if [[ ! -e $log ]]; then
    #If the log does not exist, make it's directory and the log file.
    $mkdir -p $(dirname "${log}")
    $touch $log
    #Log the event.
    $echo "$(date) Log file \"$log\" was found to not exist, created it." >> $log
fi


$ps -aux | $grep "[J]aneEngine.php" > /dev/null 2>&1
if [[ "$?" == "0" ]]; then
    $echo "JaneEngine.php is running." > /dev/null 2>&1
else
    
    #Log incident and attempt to recover.
    $echo " " >> $log
    $echo "#############################################" >> $log
    $echo "############### Jane Sentinel ###############" >> $log
    $echo "#############################################" >> $log
    $echo "#                                           #" >> $log
    $echo "# Jane Engine was not found running. Jane   #" >> $log
    $echo "# Sentinel will attempt to restart several  #" >> $log
    $echo "# services and attempt to restart the Jane  #" >> $log
    $echo "# Engine. If this continously fails, please #" >> $log
    $echo "# troubleshoot the core service statuses    #" >> $log
    $echo "# and free space for all partitions. Below  #" >> $log
    $echo "# are commands for these things.            #" >> $log
    $echo "#                                           #" >> $log
    $echo "# tail /var/log/httpd/error_log             #" >> $log
    $echo "# systemctl status httpd -l                 #" >> $log
    $echo "# systemctl status smb -l                   #" >> $log
    $echo "# systemctl status firewalld -l             #" >> $log
    $echo "# systemctl status mariadb -l               #" >> $log
    $echo "# uptime                                    #" >> $log
    $echo "# df -h                                     #" >> $log
    $echo "# ps -aux | grep \"[J]aneEngine.php\"         #" >> $log
    $echo "#                                           #" >> $log
    $echo "# Beginning service restarts...             #" >> $log
    $echo "#                                           #" >> $log
    $echo "#############################################" >> $log
    $echo " " >> $log

    $echo "Stopping httpd..." >> $log
    $systemctl stop httpd >> $log
    $echo "Stopping mariadb..." >> $log
    $systemctl stop mariadb >> $log
    $echo "Stopping smb..." >> $log
    $systemctl stop smb >> $log
    $echo "Stopping firewalld..." >> $log
    $systemctl stop firewalld >> $log
    $echo "Stopping any existing Jane Engine processes..."
    $pkill -f JaneEngine.php >> $log
    $echo "Sleeping for 10 seconds" >> $log
    $sleep 10 >> $log
    $echo "---------------------------------------------" >> $log
    $echo " " >> $log
    $echo "Starting firewalld..." >> $log
    $systemctl start firewalld  >> $log
    if [[ $? != "0" ]]; then
        $echo "Failed to start firewalld. This is not a mission-critical problem but is a security-critical problem." >> $log
        $sleep $rebootwait
    fi
    $echo "Starting mariadb..." >> $log
    $systemctl start mariadb >> $log
    if [[ $? != "0" ]]; then
        $echo "Failed to start mariadb. This is a mission-critical problem. Waiting for $rebootWait seconds, then attempting a system reboot." >> $log
        $sleep $rebootWait
        $reboot
    fi
    $echo "Starting smb..." >> $log
    $systemctl start smb >> $log
    if [[ $? != "0" ]]; then
        $echo "Failed to start smb. This is a mission-critical problem. Waiting for $rebootWait seconds, then attempting a system reboot." >> $log
        $sleep $rebootWait
        $reboot
    fi
    $echo "Starting httpd..." >> $log
    $systemctl start httpd >> $log
    if [[ $? != "0" ]]; then
        $echo "Failed to start httpd. This is a mission-critical problem. Waiting for $rebootWait seconds, then attempting a system reboot." >> $log
        $sleep $rebootWait
        $reboot
    fi
    $echo "Starting Jane Engine..." >> $log
    $nohup $php $janeEngine >> $log &
    if [[ $? != "0" ]]; then
        $echo "Failed to start Jane Engine. This is a mission-critical problem. Waiting for $rebootWait, then attempting a system reboot." >> $log
        $sleep $rebootWait
        $reboot
    fi
    $ps -aux | $grep "[J]aneEngine.php" > /dev/null 2>&1
    if [[ "$?" == "0" ]]; then
        $echo "JaneEngine.php is running again." >> $log
    fi
fi
