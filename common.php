<?php
function e( $text ){ return htmlspecialchars( $text, ENT_QUOTES, 'UTF-8' ); }

function display($r) {
	$json = json_decode(file_get_contents($r), true);
	if (isset($json["outtime"])) {
		$ft = date("c", $json["outtime"]);
		echo "<p><a href=$r><time dateTime=$ft>$ft</time> shift lasted " . ($json["outtime"] - $json["intime"]) . "s</a></p>";
	} else {
		$ft = date("c", $json["intime"]);
		echo "<p><a href=$r>" . $json["name"] . " on duty since <time dateTime=$ft>$ft</time> with mobile number " . $json["tel"] . "</a></p>";
	}
}

$id = urlencode($_SESSION["ic"]);
// Record directory
$rdir = "r/$id/";
// Current punch card
$p = "r/$id.json";

?>
