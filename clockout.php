<?php
session_start();

// If you know the IC you can log that person out
if (isset($_GET["ic"])) {
	$id = urlencode($_GET["ic"]);
} else {
	$id = urlencode($_SESSION["ic"]);
}

// Record directory
$rdir = "r/$id/";
// Current punch card
$p = "r/$id.json";

if (file_exists($p)) {
	$json = json_decode(file_get_contents($p), true);
	$json["outtime"] = time();
	$json["out"] = $_SERVER;
	file_put_contents($rdir . "/" . $json["outtime"] .  ".json", json_encode($json, JSON_PRETTY_PRINT));
	unlink($p);
} else {
	die ("You weren't clocked in!");
}


// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
	$params = session_get_cookie_params();
	setcookie(session_name(), '', time() - 42000,
		$params["path"], $params["domain"],
		$params["secure"], $params["httponly"]
	);
}

if (session_destroy()) {
	$url = 'http://' . $_SERVER['HTTP_HOST'];
	header('Location: ' . $url);
}
?>