<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
    include 'connect2db.php';
    include 'head.php';

	if ($isAdministrator == 1) {
		echo "<title>Username Tracking</title>\n";
		echo "<div>\n";
		echo "Username Tracking\n<br><br><br>\n";


		$sql = "SELECT * FROM `usernameTracking` ORDER BY `trackingIsAbnormal` DESC, `trackingImportedID` ASC";
		$result = $link->query($sql);
		if ($result->num_rows > 0) {
			echo "Number of usernames being tracked: $result->num_rows<br><br>\n";

			echo "<form action=\"clearUsernameTracking.php\" method=\"post\">\n";
			echo "Clear usernames not seen in the last\n";
			echo " <input type=\"text\" name=\"years\" value=\"15\" style=\"width:20px;\"> years.<br>\n";
			echo "<input type=\"checkbox\" name=\"ConfirmDelete\" value=\"Confirmed\">Confirm Delete<br>\n";
			echo "<input type=\"submit\" value=\"Clear Usernames\">\n";
			echo "<br><br>\n";

			echo "<table>\n";
			echo "<tr>\n";
			echo "<th>trackingImportedID</th>\n";
			echo "<th>trackingUserName</th>\n";
			echo "<th>lastSeen</th>\n";
			echo "<th>userGroup</th>\n";
			echo "</tr>\n";
			while($row = $result->fetch_assoc()) {

				$trackingImportedID = trim($row["trackingImportedID"]);
				$trackingUserName = trim($row["trackingUserName"]);
				$userGroup = trim($row["userGroup"]);
				$lastSeen = trim($row["lastSeen"]);

				$lastSeen = new DateTime("@$lastSeen");
				$lastSeen->setTimezone(new DateTimeZone("$TimeZone"));


				echo "<tr>\n";
				echo "<td>$trackingImportedID</td>\n";
				echo "<td>$trackingUserName</td>\n";
				echo "<td>" . $lastSeen->format("F j, Y, g:i a") . "</td>\n";
				echo "<td>$userGroup</td>\n";
				echo "</tr>\n";

			}
			echo "</table>\n";
		}

		echo "<br>\n";
		echo "</div>\n";
		echo "</body>\n";
		echo "</html>\n";
	}
} else {
	//Not an admin, redirect to home.
	$NextURL="jane.php";
	header("Location: $NextURL");
}
?>
