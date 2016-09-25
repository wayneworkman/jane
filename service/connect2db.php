<?php
// Create connection
$link = new mysqli($servername, $username, $password, $database);
// Check connection
if ($link->connect_error) {
        // Couldn't establish a connection with the database.
        writeLog("Couldn't connect to the database.");
}
?>
