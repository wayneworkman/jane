<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
    include 'connect2db.php';
    include 'head.php';

    if ($isAdministrator == 1) {

        echo "<div>";
        echo "<form action=\"NewSettings.php\" method=\"post\">";
        echo "New Settings<br>";
        echo "<p class=\"tab\">";
        echo "<br>";
        echo "Settings Nickname:<br>";
        echo "<input type=\"text\" name=\"NewSettingsNickName\"><br>";
        echo "<br>";
        echo "Settings Type:<br>";
        echo "<select name='NewSettingsType'>";
        echo "<option value='0'>Pick Settings Type</option>";
        $sql = "SELECT `SettingsTypeID`,`SettingsTypeName` from `janeSettingsTypes`";
        $result = $link->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . trim($row['SettingsTypeID']) . "'>" . trim($row['SettingsTypeName']) . "</option>";
            }
            $result->free();
        } else {
            echo "<option value='no_users'>no_settings</option>";
        }
        echo "</select><br>";
        echo "<br>";
        echo "Settings Group:<br>";
        echo "<select name='NewSettingsGroup'>";
        echo "<option value='0'>Pick Group</option>";
        $sql = "SELECT `JaneGroupID`,`JaneGroupName` from `janeGroups`";
        $result = $link->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . trim($row['JaneGroupID']) . "'>" . trim($row['JaneGroupName']) . "</option>";
            }
            $result->free();
        } else {
            echo "<option value='no_groups'>no_settings</option>";
        }
        echo "</select><br>";
        echo "<br>";

        echo "IP Allowed Access:<br>";
        echo "<input type=\"text\" name=\"JaneSettingsSMBallowedIP\" style=\"width:600px;\"><br>";
        echo "<br>";

        echo "WHERE:<br>";
        echo "<input type=\"text\" name=\"JaneSettingsWHERE\" style=\"width:600px;\"><br>";
        echo "Examples:<br>";
        echo "<font color=\"red\">userGroup = &#39;Site 5&#39;</font><br>";
        echo "<font color=\"red\">userGroup = &#39;South Branch&#39;</font><br>";
        echo "<font color=\"red\">userGroup = &#39;Site 7&#39; OR userGroup = &#39;Site 8&#39;</font><br>";
        echo "<br>";
        echo "The WHERE setting is included as part of the SQL SELECT statement used with selecting data from the <font color=\"red\">userDataToImport</font> table. Any data matching this WHERE clause will be included in processing for this group of settings. No escaping is performed on these values because they are directly used upon the database. Therefore they are only available to administrators.<br>";
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
