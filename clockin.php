<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Punched in <?php echo session_id();?></title>
<meta name=viewport content="width=device-width, initial-scale=1">
</head>
<body>
<?php
session_start();

if (isset($_GET["ic"])) {
	$_SESSION = $_GET;
} else {
	die("<a href=/>Click Here to Login</a>");
}

$id = urlencode($_SESSION["ic"]);
// Record directory
$rdir = "r/$id/";
// Current punch card
$p = "r/$id.json";

// print_r($_SESSION);

if (! file_exists($rdir)) {
	if (!mkdir($rdir, 0777, true)) {
		die('Failed to create dir ' . $rdir);
	} else {
		echo '<h1>Welcome ' . $_SESSION["name"] . '</h1>';
	}
}

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

if (file_exists($p)) {
	echo "<p>On call</p>";
	display($p);
} else {
	echo "<p>Putting you on call</p>";
	// Clock in
	$_SESSION["intime"] = time();
	// Save server info (might be useful)
	$_SESSION["in"] = $_SERVER;
	file_put_contents($p, json_encode($_SESSION, JSON_PRETTY_PRINT));
	display($p);
}

?>

<h1><a href=/clockout.php>Clock out</a></h1>

<h3>Previous sessions</h3>
<ul>
<?php
foreach (glob($rdir . "/*.json") as $session) {
	display($session);
}
?>
</ul>
</body>
</html>
