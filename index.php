<?php
session_start();
if ($_SESSION["ic"]) {
	// If there is an existing session, do not bother to login
	$url = 'http://' . $_SERVER['HTTP_HOST'];
	header('Location: ' . $url . "/login.php"); 
	die();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Punch in <?php echo session_id();?></title>  
<meta name=viewport content="width=device-width, initial-scale=1">
<style>
body { font-family: sans-serif; }
form { display: flex; flex-direction: column; }
.row { display: flex;}
input { font-size: 1.8em; padding: 0.3em; box-sizing: border-box;  display: block; flex: 1;}
input:focus { background-color: #FFFFCC; }
</style>
<script src=main.js></script>
</head>
<body>

<form action=/login.php method=GET autocomplete=on>

<!-- https://en.wikipedia.org/wiki/Malaysian_identity_card -->
<input required name=ic placeholder="IC">

<input required name=name placeholder="Name">
<input required name=tel type=tel placeholder="Mobile number">

<input type=submit value="Clock in">

</form>

<h3>Clocked in users</h3>
<ol>
<?php
foreach (glob("r/*.json") as $responder) { 
	$json = json_decode(file_get_contents($responder), true);
	$ft = date("c", $json["starttime"]);
	echo "<li><a title=\"" . $json["ic"] . "\" href=tel:" . $json["tel"] . ">" . $json["name"] . "</a> <time dateTime=$ft>$ft</time> <button>Clock out</button></li>";
}
?>
</ol>

<h3>PHP sessions</h3>
<ul>
<?php
foreach (glob(session_save_path() . "/*") as $activesession) { 
	echo "<li>" . basename($activesession) . "</li>";
}
?>
</ul>
<pre>
<?php if(!empty($_SESSION)) { print_r($_SESSION); } ?>
</pre>

</body>
</html>
