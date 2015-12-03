<?php
function e( $text ){ return htmlspecialchars( $text, ENT_QUOTES, 'UTF-8' ); }

function display($r) {
	$json = json_decode(file_get_contents($r), true);
	if (isset($json["outtime"])) {
		$ft = date("c", $json["outtime"]);
		echo "<p><a href=$r><time dateTime=$ft>$ft</time> shift lasted " . ($json["outtime"] - $json["intime"]) . "s</a></p>";
	} else {
		$ft = date("c", $json["intime"]);
		echo "<p><a href=$r>" . e($json["name"]) . " on duty since <time dateTime=$ft>$ft</time> with mobile number " . e($json["tel"]) . "</a></p>";
	}
}
?>
