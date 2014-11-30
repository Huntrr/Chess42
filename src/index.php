<!DOCTYPE html>
<html>
    <head>
        <title>Chess 4-2</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>
        <div class="container">
            <h1>Chess 4-2</h1>
        </div>
        <div class="container">
            <h2>Choose options and hit play</h2>
            <form action="start.php" method="post">
                Side: <br> <select name="side" size=2>
                        <option value="white" selected>White</option>
                        <option value="black">Black</option>
                      </select><br><br>
                
                Allow Undos: <input type="checkbox" name="undos" checked><br><br>
                
                Display PGN: <input type="checkbox" name="pgn" checked><br><br>
                
                Sandbox Play: <input type="checkbox" name="sandbox" ><br><br>
                
                Starting position: <br><textarea name="pos" rows="5" cols="50" ></textarea><br><br>
                
                <input type="submit" value="Play now!">
            </form>
        </div>
    </body>
</html>