<?php
include 'localVars.php';
include 'connect2db.php';

$localUsers = shell_exec('cut -d: -f1 /etc/passwd');


$SystemLocalUsers = array();
foreach(preg_split("/((\r?\n)|(\r\n?))/", $localUsers) as $user){
    $SystemLocalUsers[] = $user;
}

foreach ($SystemLocalUsers as $LocalUser) {
	echo "$LocalUser\n";
}



?>
