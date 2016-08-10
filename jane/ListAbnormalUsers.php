<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
    include 'connect2db.php';
    include 'head.php';


    //List abnormal users for all Jane users to see.
    echo "<div>";
    echo "<font color=\"red\">List of abnormal usernames (ID userGroup Username):</font><br>";
    $sql = "SELECT `trackingImportedID`, `trackingUserName`, `userGroup` FROM `usernameTracking`WHERE `trackingIsAbnormal`='1' ORDER BY `trackingImportedID` desc";
    echo "<br>";
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "&emsp;&emsp;" . $row["trackingImportedID"] . "&emsp;" . $row["userGroup"] . "&emsp;" . $row["trackingUserName"] . "<br>";
        }
        $result->free();
    }
    echo "</div>";
    echo "</body>";
    echo "</html";
}
?>
