<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
    include 'connect2db.php';
    include 'head.php';


    //List abnormal users for all Jane users to see.
    echo "<title>Abnormal Users</title>\n";
    echo "<div>\n";
    echo "<font color=\"red\">List of abnormal usernames</font><br><br>\n";
    $sql = "SELECT `trackingImportedID`, `trackingUserName`, `userGroup`, `abnormalReason` FROM `usernameTracking`WHERE `trackingIsAbnormal`='1' ORDER BY `trackingImportedID` desc";

    $result = $link->query($sql);
    if ($result->num_rows > 0) {

	echo "<table>\n";
        echo "<tr>\n";
        echo "<th>ID</th>\n";
        echo "<th>Username</th>\n";
        echo "<th>UserGroup</th>\n";
	echo "<th>Reason</th>\n";
        echo "</tr>\n";
        while($row = $result->fetch_assoc()) {

                $abnormalID = trim($row["trackingImportedID"]);
                $abnormalUsername = trim($row["trackingUserName"]);
                $abnormalUserGroup = trim($row["userGroup"]);
		$abnormalReason = trim($row["abnormalReason"]);

                echo "<tr>\n";
                echo "<td>$abnormalID</td>\n";
                echo "<td>$abnormalUsername</td>\n";
                echo "<td>$abnormalUserGroup</td>\n";
		echo "<td>$abnormalReason</td>\n";
                echo "</tr>\n";

        }
	echo "</table>\n";
        $result->free();
    }
    echo "</div>\n";
    echo "</body>\n";
    echo "</html>\n";
}
?>
