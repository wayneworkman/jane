<?php
if ($SessionIsVerified != "1") {
        $NextURL="login.php";
        header("Location: $NextURL");
}
// Create connection
$link = new mysqli($servername, $username, $password, $database);
// Check connection
if ($link->connect_error) {
        // Couldn't establish a connection with the database.
        die($SiteErrorMessage);
}
?>
