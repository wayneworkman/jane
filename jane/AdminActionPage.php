<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
    include 'connect2db.php';
    include 'head.php';

    if ($isAdministrator == 1) {
        echo "<title>User, Group, and IP Management</title>";
        echo "<div>";
        echo "<form action=\"AdminAction.php\" method=\"post\">";
        echo "User, Group, and IP Management<br>";
        echo "<p class=\"tab\">";


        echo "Text for selected action:<br><input type=\"text\" name=\"adminActionText\"><br>";
        echo "<br>";


        $GroupIDs = array();
        $GroupNames = array();
        $UserIDs = array();
        $UserNames = array();

        echo "<select name='uID'>";
        echo "<option value=''>Pick User</option>";
        $sql = "SELECT `JaneUsername`,`JaneUserID` from `janeUsers`";
        $result = $link->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . trim($row['JaneUserID']) . "'>" . trim($row['JaneUsername']) . "</option>";
                $UserIDs[] = trim($row['JaneUserID']);
                $UserNames[] = trim($row['JaneUsername']);
            }
            $result->free();
        } else {
            echo "<option value='no_users'>no_users</option>";
        }
        echo "</select>";

        echo "<select name='gID'>";
        echo "<option value=''>Pick Group</option>";
        $sql = "SELECT `JaneGroupID`,`JaneGroupName` from `janeGroups`";
        $result = $link->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . trim($row['JaneGroupID']) . "'>" . trim($row['JaneGroupName']) . "</option>";
                $GroupIDs[] = trim($row['JaneGroupID']);
                $GroupNames[] = trim($row['JaneGroupName']);
            }
            $result->free();
        } else {
            echo "<option value='no_groups'>no_settings</option>";
        }
        echo "</select><br>";
        echo "<br>";

        $i = 0;
        foreach ($adminActionNames as $adminAction) {
            echo "<input type=\"radio\" name=\"adminAction\" value=\"$adminAction\">$adminAction<br>";
            $i = $i + 1;
        }

        echo "<br>";
        echo "<input type=\"submit\">";
        echo "</form>";
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
