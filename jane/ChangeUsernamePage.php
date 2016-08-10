<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
    include 'connect2db.php';
    include 'head.php';

    echo "<div>";
    echo "<form action=\"ChangeUsername.php\" method=\"post\">";
    echo "Change Username<br>";
    echo "<p class=\"tab\">";
    echo "Old Username:<br><input type=\"text\" name=\"OldUsername\"><br>";
    echo "New Username:<br><input type=\"text\" name=\"NewUsername\"><br>";
    echo "Note:<br>Changing usernames does not affect group membership. This username change will apply to the Jane username and SMB username.<br>";
    echo "<br>";
    echo "<input type=\"submit\">";
    echo "</form>";
    echo "</div>";
    echo "</body>";
    echo "</html>";
}
?>
