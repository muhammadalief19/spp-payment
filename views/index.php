<?php
session_start();
if(!isset($_SESSION["login"])) {
    header("Location:login.php");
}
?>
<!-- template struktur dasar html  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../dist/output.css">
</head>
<body>
    
</body>
</html>
*/