<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>IP-Projekt</title>
</head>
<body class= "Container">
    <h1>Prohlížeč databáze</h1>

    <?php
        echo "a";
        require_once("includes/db_connect.inc.php");
        echo "b"
        echo "<ul class='list-group'>";
        echo "<li class='list-group-item'><a href='zamestnanci.php'>Seznam zaměstnanců</a></li>";
        echo "<li class='list-group-item'><a href='mistnosti.php'>Seznam místností</a></li>";
        echo "</ul>";
    ?>
</body>
</html>