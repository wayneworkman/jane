<?php

// Make sure the connection is still alive, if not, try to reconnect. DO NOT proceed without a good connection.
while(!$link->ping()) {
	writeLog("Lost connection to the database. Not doing anything until the connection can be re-established.");
	//Attempt a re-connect.
	include 'connect2db.php';
}


?>
