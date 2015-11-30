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

error_reporting(E_ALL);

$starttime = time();

if (empty($starttime)) {
	die("No start time found on session");
}

if (isset($_GET["ic"])) {
	$_SESSION = $_GET;
}

print_r($_SESSION);

if (empty($_SESSION['name'])) {
	die("<a href=/>Click Here to Login</a>");
}

$rdir = "r/" . urlencode($_SESSION["ic"]);

if (! file_exists($rdir)) {
	if (!mkdir($rdir, 0777, true)) {
		die('Failed to create dir ' . $rdir);
	} else {
		echo '<h1>Welcome ' . $_SESSION["name"] . '</h1>';
	}
}

if (file_exists($rdir . "/in.json")) {
	$json = json_decode(file_get_contents($rdir . "/in.json"));
	echo "<p>JSON start time: " . $json->starttime . "</p>";
	echo "<p>You're on call since <time>" . date("c", $json->starttime) . "</time> or " . (time() - $json->starttime) . "s</p>";
	echo "<pre>";
	print_r($json);
	echo "</pre>";
} else {
	echo "<p>Putting you on call</p>";
	echo "<p>Session start time: " . $starttime . "</p>";
	if (isset($starttime)) {
		$_SESSION["starttime"] = $starttime;
		file_put_contents($rdir . "/in.json", json_encode($_SESSION, JSON_PRETTY_PRINT));
		echo("Wrote in.json");
	}
}

echo "<pre>\$_SESSION:";
print_r($_SESSION);
echo "</pre>";

echo date("c", $starttime);

?>

<p><a href=/logout.php>Logout</a></p>

<ul>
<?php
foreach (glob($rdir . "/*.json") as $session) { 
	echo "<li>" . basename($session) . "</li>";
}
?>
</ul>
