<?php
$USERNAME = "FAKE USERNAME";
$PASSWORD = "FAKE PASSWORD";
$HOST = "FAKE HOST";
$MAIN_TABLE = "FAKE TABLE";
    
$db = new mysqli($HOST, $USERNAME, $PASSWORD, $USERNAME);

    if($db->connect_errno > 0){
        die('Unable to connect to database [' . $db->connect_error . ']');
    }

$id = '0';
$pos = '""';
$side = 'white';
$undos = 1;
$pgn = 1;
$sandbox = 0;

if($_GET['act'] == "get") {
    $id = $_GET["id"];
    
     $stmt = $db->prepare("SELECT `pos` FROM `$MAIN_TABLE` WHERE `ind` = ?;");
        $stmt->bind_param('i', $id);
        
        $stmt->execute();
        $stmt->bind_result($r_pos);
        
        $data = array();
        while($stmt->fetch()) {
            $pos = $r_pos;
        }
     
        // Close statement object
        $stmt->close();
        
        echo json_encode(array($pos));
    
    $db->close();
    exit;
}

if($_POST['act'] == "set") {
    $id = $_POST["id"];
    $newPos = $_POST["pos"];
    
     $stmt = $db->prepare("UPDATE `$MAIN_TABLE` SET `pos` = ? WHERE `ind` = ?;");
        $stmt->bind_param('si', $newPos, $id);
        
        $stmt->execute();
     
        // Close statement object
        $stmt->close();
        
        echo json_encode("DONE");
    
    $db->close();
    exit;
}

if($_GET) {
    $id = $_GET["id"];
    $side = $_GET["side"];
    
     $stmt = $db->prepare("SELECT `pos`, `undos`, `pgn`, `sandbox` FROM `$MAIN_TABLE` WHERE `ind` = ?;");
        
        
        $stmt->bind_param('i', $id);
        
        $stmt->execute();
        $stmt->bind_result($r_pos, $r_undos, $r_pgn, $r_sandbox);
        
        $data = array();
        while($stmt->fetch()) {
            $pos = $r_pos;
            $undos = $r_undos;
            $pgn = $r_pgn;
            $sandbox = $r_sandbox;
        }
     
        // Close statement object
        $stmt->close();
}

$db->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    
        <title>Chess 4-2</title>
        
        <link rel="stylesheet" href="css/style.css" />
        
        <script>
            var s_id = <?php echo $id; ?>;
            var s_pos = <?php echo "'" . $pos . "'"; ?>;
            var s_side = <?php echo "'" . $side . "'"; ?>;
            var s_undos = <?php if($undos == 1) { echo 'true'; } else { echo 'false'; } ?>;
            var s_pgn = <?php if($pgn == 1) { echo 'true'; } else { echo 'false'; } ?>;
            var s_sandbox = <?php if($sandbox == 1) { echo 'true'; } else { echo 'false'; } ?>;
        </script>
        
	    <script src="js/jquery.js"></script>
	    <script src="js/chessboard.js"></script>
	    <script src="js/chess.js"></script>
	    <script src="js/game.js"></script>
    </head>
    <body>
        <div class="container hide">
            <h1 class="hide">Chess 4-2</h1>
            <p>Send this link to your opponent: <input type="textbox" value="http://hunterlightman.com/chess/play.php?side=<?php if($side=='white') { echo 'black'; } else { echo 'white'; } ?>&id=<?php echo $id; ?>"></p>
        </div>
    
        <div class="container">
            <p class="hide"><span id="status" style="font-weight: BOLD;"></span></p>
            <div id="board"></div><br class="hide">
            <p class="show pad"><span id="status2" style="font-weight: BOLD;"></span></p>
            <input type="button" id="undo" value="Undo Move" <?php if($undos == 0 || $sandbox == 1) { echo "disabled"; } ?>/>
            <input type="button" id="flip" value="Flip Board" />
        </div>
        
        <div class="container" <?php if($pgn == 0 || $sandbox == 1) { echo 'style="display:none;"'; } ?>>
            <p style="text-align:left; font-weight: BOLD;">PGN:</p>
            <p style="text-align:left;"><span id="pgn"></span></p>
        </div>
        
        <div class="container show">
            <p>Send this link to your opponent: <input type="textbox" value="http://hunterlightman.com/chess/play.php?side=<?php if($side=='white') { echo 'black'; } else { echo 'white'; } ?>&id=<?php echo $id; ?>"></p>
        </div>
    </body>
</html>