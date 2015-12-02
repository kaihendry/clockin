<?php
session_start();
$rdir = "r/" . urlencode($_SESSION["ic"]);
if (file_exists($rdir . "/in.json")) {
	$json = json_decode(file_get_contents($rdir . "/in.json"), true);
	$json["endtime"] = time();
	$json["SERVER"] = $_SERVER;
	file_put_contents($rdir . "/" . $json["endtime"] .  ".json", json_encode($json, JSON_PRETTY_PRINT));
	unlink($rdir . "/in.json");
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
