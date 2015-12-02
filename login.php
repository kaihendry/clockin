<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Punched in <?php echo session_id();?></title>
<meta name=viewport content="width=device-width, initial-scale=1">
</head>
<body>
<?php

$id = urlencode($_SESSION["ic"]);

if (isset($_GET["ic"])) {
	$_SESSION = $_GET;
}

print_r($_SESSION);

if (empty($_SESSION['name'])) {
	die("<a href=/>Click Here to Login</a>");
}

// Record directory
$rdir = "r/$id";
// Current punch card
$p = $rdir . ".json";

if (! file_exists($rdir)) {
	if (!mkdir($rdir, 0777, true)) {
		die('Failed to create dir ' . $rdir);
	} else {
		echo '<h1>Welcome ' . $_SESSION["name"] . '</h1>';
	}
}

function display($r) {
	$json = json_decode(file_get_contents($p), true);
	echo "<pre>";
	print_r($json);
	echo "</pre>";
}

if (file_exists($p)) {
	echo "<p>You are already on call</p>";
	display($p);
} else {
	echo "<p>Putting you on call</p>";
	// Clock in
	$_SESSION["starttime"] = time();
	file_put_contents($p, json_encode($_SESSION, JSON_PRETTY_PRINT));
	display($p);
}

echo "<pre>\$_SESSION:";
print_r($_SESSION);
echo "</pre>";

?>

<p><a href=/logout.php>Clock out</a></p>

<h3>Previous sessions</h3>
<ul>
<?php
foreach (glob($rdir . "/*.json") as $session) {
	echo "<li>" . basename($session) . "</li>";
}
?>
</ul>
