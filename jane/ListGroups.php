<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
    include 'connect2db.php';
    include 'head.php';

    if ($isAdministrator == 1) {

        $GroupIDs = array();
        $GroupNames = array();
        $UserIDs = array();
        $UserNames = array();

        $sql = "SELECT `JaneUsername`,`JaneUserID` from `janeUsers`";
        $result = $link->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $UserIDs[] = trim($row['JaneUserID']);
                $UserNames[] = trim($row['JaneUsername']);
            }
            $result->free();
        }

        $sql = "SELECT `JaneGroupID`,`JaneGroupName` from `janeGroups`";
        $result = $link->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $GroupIDs[] = trim($row['JaneGroupID']);
                $GroupNames[] = trim($row['JaneGroupName']);
            }
            $result->free();
        }

        echo "<title>List Groups</title>";
        echo "<div>";
        echo "<form>";
        // List group's users, and user's groups.	

        echo "List of all groups, and the users in each:<br><br>";
        $i = 0;
        foreach ($GroupIDs as $GroupID) {
            $sql = "SELECT `JaneUsername` FROM `janeUsers` WHERE `JaneUserID` IN (SELECT `uID` FROM `janeUserGroupAssociation` WHERE `gID` = '$GroupID')";
            $result = $link->query($sql);
            echo "&emsp;&emsp;<font color=\"blue\">$GroupNames[$i]</font><br>";
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "&emsp;&emsp;&emsp;&emsp;" . $row["JaneUsername"] . "<br>";
                }
                $result->free();
            }
            echo "<br>";
            $i = $i + 1;
        }
        echo "</div>";
        echo "</body>";
        echo "</html>";
    }
} else {
    //Not an admin, redirect to home.
    $NextURL="jane.php";
    header("Location: $NextURL");
}
?>
