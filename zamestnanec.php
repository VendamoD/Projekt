<?php
require_once("includes/db_connect.inc.php");
$employeeId = (int) ($_GET['employeeId'] ?? 0);


$card = $pdo->query('SELECT e.employee_id, e.name AS ename, e.surname, e.job, e.wage, r.name AS rname, r.room_id FROM employee e INNER JOIN room r ON e.room=r.room_id WHERE e.employee_id='.$employeeId);
$card->execute(['employeeId' => $employeeId]);

if ($card->rowCount() == 0){
    http_response_code(404);
    $success = false;
} else {
    $success = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
</head>
<body class="container">
    <div>
        <?php
        if(!$success){
            echo "<title>ERROR 404</title>";
            echo "<h1>Error 404 Not Found</h1>";
            echo "STRÁNKA NENALEZENA";
            exit();
        } else {

        $html =  "<dl class='dl-horizontal'>";

        while ($row = $card->fetch()) {
            $html = $html."<h1>Karta osoby: ".htmlspecialchars($row->surname)." ".substr(htmlspecialchars($row->ename), 0, 1).".</h1><dt>Jméno</dt><dd>".htmlspecialchars($row->ename)."</dd><dt>Příjmení</dt><dd>".htmlspecialchars($row->surname)."</dd><dt>Pozice</dt><dd>".htmlspecialchars($row->job)."</dd><dt>Mzda</dt><dd>".htmlspecialchars($row->wage)."</dd><dt>Místnost</dt><dd><a style='text-decoration:none' href='mistnost.php?roomId={$row->room_id}'>".htmlspecialchars($row->rname)."</a></dd><dt>Klíče</dt>";
        }

        $keys = $pdo->query('SELECT r.name, r.room_id FROM `key` k INNER JOIN room r ON r.room_id=k.room WHERE `employee` ='.$employeeId);

        while($row = $keys->fetch()){
            $html = $html."<dd><a style='text-decoration:none' href='mistnost.php?roomId={$row->room_id}'>".htmlspecialchars($row->name)."</a></dd>";
        }

        $html = $html."</dl>";
        $html = $html."<h3><a style='text-decoration:none' href=zamestnanci.php>Zpět na Seznam zaměstnanců</a></h3>";
        echo $html;
    }
        ?>
    </div>
    <header>
        <?php

        $card = $pdo->query('SELECT e.employee_id, e.name AS ename, e.surname AS esurname FROM employee e INNER JOIN room r ON e.room=r.room_id WHERE e.employee_id='.$employeeId);

        while ($row = $card->fetch()) {
            echo "<title>Karta osoby ".htmlspecialchars($row->esurname)." ".substr(htmlspecialchars($row->ename), 0, 1).".</title>";
        }
        unset($card);
        unset($keys);
        ?>
    </header>
</body>
</html