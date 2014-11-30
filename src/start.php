<?php
$USERNAME = "FAKE USERNAME";
$PASSWORD = "FAKE PASSWORD";
$HOST = "FAKE HOST";
$MAIN_TABLE = "FAKE TABLE";
    
$db = new mysqli($HOST, $USERNAME, $PASSWORD, $USERNAME);

    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }


$pos = '';
$side = 'white';
$undos = 1;
$pgn = 1;
$sandbox = 0;
$uuid = 0;
        
$stmt1 = $db->prepare("INSERT INTO $MAIN_TABLE (ind, pos, side, undos, pgn, sandbox) VALUES (?, ?, ?, ?, ?, ?);");
$stmt1->bind_param('issiii', $uuid, $pos, $side, $undos, $pgn, $sandbox);

$uuid = mt_rand();
    
$pos = $_POST["pos"];
$side = $_POST["side"];
if($_POST["undos"]) {
    $undos = 1;
} else {
    $undos = 0;
}

if($_POST["pgn"]) {
    $pgn = 1;
} else {
    $pgn = 0;
}

if($_POST["sandbox"]) {
    $sandbox = 1;
} else {
    $sandbox = 0;
}

while($stmt1->execute() == false) {
    $uuid = mt_rand();
}
$stmt1->close();

$db->close();

        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP-SELF']), '/\\');
        $page = 'chess/play.php';
        header("Location: http://$host$uri/$page?id=$uuid&side=$side");
        
        exit;
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Chess 4-2</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>
        <div class="container">
            <h1>Loading...</h1>
        </div>
    </body>
</html>