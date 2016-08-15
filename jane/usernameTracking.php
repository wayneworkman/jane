<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
    include 'connect2db.php';
    include 'head.php';

    if ($isAdministrator == 1) {
        echo "<title>Username Tracking</title>";
        echo "<div>";
        echo "Username Tracking<br>";
	echo "<br><br>";


$sql = "SELECT * FROM `usernameTracking` ORDER BY `trackingIsAbnormal` DESC, `trackingImportedID` ASC";
$result = $link->query($sql);
if ($result->num_rows > 0) {
	echo "<table>\n";
	echo "<tr>\n";
	echo "<th>trackingImportedID</th>\n";
	echo "<th>trackingUserName</th>\n";
	echo "<th>userGroup</th>\n";
	echo "</tr>\n";
        while($row = $result->fetch_assoc()) {

                $trackingImportedID = trim($row["trackingImportedID"]);
                $trackingUserName = trim($row["trackingUserName"]);
                $userGroup = trim($row["userGroup"]);

		echo "<tr>\n";
		echo "<td>$trackingImportedID</td>\n";
		echo "<td>$trackingUserName</td>\n";
		echo "<td>$userGroup</td>\n";
		echo "</tr>\n";

        }
	echo "</table>\n";
}

	echo "<br>";
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
