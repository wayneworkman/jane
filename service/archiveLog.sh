date=$(command -v date)
echo=$(command -v echo)
log="/jane/log/JaneEngine.log"
directory="/jane/log"
mv=$(command -v mv)
touch=$(command -v touch)
chmod=$(command -v chmod)
chown=$(command -v chown)



stamp=$(date +%Y%m%d_%H%M%S)
$mv $log $directory/JaneEngine-$stamp.log
$touch $log
$chown root:apache $log
$chmod 770 $log
$echo "Last month's JaneEngine log file has been moved to $directory/JaneEngine-$stamp.log" >> $log

