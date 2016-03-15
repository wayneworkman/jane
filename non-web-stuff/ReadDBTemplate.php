<?php
include 'vars.php';
include 'verifysession.php';


$sql = "SELECT Column1,Column2,Column3 FROM MyTable";
$result = $link->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$Column1 = $row["Column1"];
		$Column2 = $row["Column2"];
		$Column3 = $row["Column3"];
	}
}
?>

