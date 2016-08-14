<?php
include 'vars.php';
include 'verifysession.php';
if ($SessionIsVerified == "1") {
    include 'connect2db.php';
    include 'head.php';

    if ($isAdministrator == 1) {
        echo "<title>Show Sessions</title>";
        echo "<div>";
        echo "Show Sessions<br>";
	echo "<br><br>";
	echo "<form action=\"clearSessions.php\" method=\"post\">";
	echo "<input type=\"submit\" value=\"Clear All Session Data\">";
	echo "<br><br>";

	$sql = "SELECT `Sessions`.`REQUEST_TIME`, `janeUsers`.`JaneUsername`, `Sessions`.`REMOTE_ADDR`, `Sessions`.`HTTP_USER_AGENT` FROM `Sessions` INNER JOIN `janeUsers` ON `Sessions`.`SessionUserID`=`janeUsers`.`JaneUserID` ORDER BY `Sessions`.`REQUEST_TIME` DESC;";
	$result = $link->query($sql);
	if ($result->num_rows > 0) {
	echo "Number of session records: $result->num_rows<br><br>";
	echo "<table>\n";
	echo "<tr>\n";
        echo "<th>REQUEST_TIME</th>\n";
	echo "<th>Username</th>\n";
	echo "<th>REMOTE_ADDR</th>\n";
	echo "<th>HTTP_USER_AGENT</th>\n";
	echo "</tr>\n";
        while($row = $result->fetch_assoc()) {

                $sessionsRequestTime = trim($row["REQUEST_TIME"]);
                $sessionsJaneUsername = trim($row["JaneUsername"]);
                $sessionsRemoteAddr = trim($row["REMOTE_ADDR"]);
		$sessionsHttpUserAgent = trim($row["HTTP_USER_AGENT"]);

		echo "<tr>\n";

		echo "<td>";
		$sessionsDatetime = new DateTime("@$sessionsRequestTime");
		$sessionsDatetime->setTimezone(new DateTimeZone("$TimeZone"));
		echo $sessionsDatetime->format("F j, Y, g:i a");
		echo "</td>\n";

		echo "<td>$sessionsJaneUsername</td>\n";
		echo "<td>$sessionsRemoteAddr</td>\n";
		echo "<td>$sessionsHttpUserAgent</td>\n";
		echo "</tr>\n";

        }
	unset($result);
	unset($sessionsDateTime);
	unset($sessionsRequestTime);
	unset($sessionsJaneUsername);
	unset($sessionsRemoteAddr);
	unset($sessionsHttpUserAgent);
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
