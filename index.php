<?php

require_once "config/config.php";

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/app.css">
    <script src="js/MyUtils.js"></script>
    <script src="js/app.js"></script>
</head>
<body onload="onReady()">
    <h1>MY COMMENTS SYSTEM</h1>

    <div class="new-message-bar"><a id="link-new-message" href="#">New message</a></div>

        <ul class="container">
        </ul>

    <div id="popup-form" class="popup">
    </div>
</body>
</html>