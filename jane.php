<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<title>Jane</title>
<style>
div{width:400px;padding:10px;border:5px solid gray;margin:0}
<!--
.tab { margin-left: 40px; }
-->
</style>
</head>
<body>
<form action="doAction.php" method="post">

<div>
<?php

include 'vars.php';

mysql_connect($servername, $username, $password);
mysql_select_db($database);

$sql = "SELECT SettingsNickName FROM janeAD";
$result = mysql_query($sql);

echo "<select name='SettingsNickName'>";

echo "<option value='0'>Pick Settings NickName</option>";

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['SettingsNickName'] . "'>" . $row['SettingsNickName'] . "</option>";
}
echo "</select><br>";

?>
<br>


<input type="radio" name="Action" value="edit" checked>Edit
<br>
<input type="radio" name="Action" value="delete">Delete
<br>
SettingsPassword<br>
<input type="password" name="SettingsPassword" value=""><br>
</div>



<div>
<input type="radio" name="Action" value="new">New<br>


<p class="tab">
<input type="radio" name="NewSettingType" value="AD">Active Directory<br>
<input type="radio" name="NewSettingType" value="OD10.9">Open Directory (OSX 10.9)<br>
</p>


</div>
<br>
<input type="submit">

</form>
</body>
</html>

