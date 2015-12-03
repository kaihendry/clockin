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
	$_SESSION["ic"] = $_GET["ic"];
	$_SESSION["name"] = $_GET["name"];
	$_SESSION["tel"] = $_GET["tel"];
}

require("common.php");

if (empty($_SESSION["ic"])) {
	die("<a href=/>Click Here to Login</a>");
}

if (! file_exists($rdir)) {
	if (!mkdir($rdir, 0777, true)) {
		die('Failed to create dir ' . $rdir);
	} else {
		echo '<h1>Welcome ' . e($_SESSION["name"]) . '</h1>';
	}
}

if (file_exists($p)) {
	echo "<p>On call</p>";
	display($p);
} else {
	echo "<p>Putting you on call</p>";
	// Clock in
	$ci = $_SESSION;
	$ci["intime"] = time();
	// Save server info (might be useful)
	$ci["sin"] = $_SERVER;
	file_put_contents($p, json_encode($ci, JSON_PRETTY_PRINT));
	display($p);
}

?>

<h1><a href=/clockout.php>Clock out</a></h1>

<h3>Previous sessions</h3>
<ul>
<?php
foreach (glob($rdir . "/*.json") as $shifts) {
	display($shifts);
}
?>
</ul>
</body>
</html>
