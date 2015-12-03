<?php
session_start();

// If you know the IC you can log that person out
if (isset($_GET["ic"])) {
	$_SESSION["ic"] = $_GET["ic"];
}

$id = urlencode($_SESSION["ic"]);
// Record directory
$rdir = "r/$id/";
// Current punch card
$p = "r/$id.json";

if (file_exists($p)) {
	$json = json_decode(file_get_contents($p), true);
	$json["outtime"] = time();
	$json["sout"] = $_SERVER;
	file_put_contents($rdir . "/" . $json["outtime"] .  ".json", json_encode($json, JSON_PRETTY_PRINT));
	unlink($p);
} else {
	die ("You weren't clocked in!");
}

// Unset all of the session variables.
$_SESSION = array();

if (session_destroy()) {
	$url = 'http://' . $_SERVER['HTTP_HOST'];
	header('Location: ' . $url);
}
?>
