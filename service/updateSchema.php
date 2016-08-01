<?php

$servername = 'localhost';
$username = 'janeSystem';
$password = 'janesystempassword';
$database = 'jane';


// Create connection
$link = new mysqli($servername, $username, $password, $database);
// Check connection
if ($link->connect_error) {
        // Couldn't establish a connection with the database.
        die($SiteErrorMessage);
}


//Get current db schema.
$sql = "SELECT settingValue FROM globalSettings WHERE settingKey = 'schemaVersion' LIMIT 1";
$result = $link->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $schemaVersion = trim($row["settingValue"]);
    }
}
echo $schemaVersion;

?>
