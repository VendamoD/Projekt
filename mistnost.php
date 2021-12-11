<?php
require_once("includes/db_connect.inc.php");
$roomId = (int) ($_GET['roomId'] ?? 0);

$card = $pdo->query('SELECT room_id, no, name, phone FROM room WHERE room_id='.$roomId);
$card->execute(['roomId' => $roomId]);

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
            echo "STRÁNKA NENALEZNUTA";
            exit();
        } else {

        $html = "<dl class='dl-horizontal'>";

        while ($row = $card->fetch()) {
            $html = $html."<h1>Místnost č. ".htmlspecialchars($row->no)."</h1><dt>Číslo</dt><dd>".htmlspecialchars($row->no)."</dd><dt>Název</dt><dd>".htmlspecialchars($row->name)."</dd><dt>Telefon</dt><dd>".htmlspecialchars($row->phone)."</dd><dt>Lidé</dt>";
        }

        $employees = $pdo->query('SELECT AVG(e.wage) as avgwage, e.name AS ename, e.surname, e.employee_id FROM employee e INNER JOIN room r ON e.room=r.room_id WHERE r.room_id='.$roomId);

        while ($row = $employees->fetch()) {
        $html = $html."<dd><a style='text-decoration:none' href='zamestnanec.php?employeeId={$row->employee_id}'>".htmlspecialchars($row->surname)." ".substr($row->ename, 0, 1).".</a></dd>";
        $html = $html."<dt>Průměrná mzda<dt><dd>".htmlspecialchars($row->avgwage)."</dd>";
        }
        $html = $html."<dt>Klíče</dt>";

        $keys = $pdo->query('SELECT e.employee_id, e.name AS ename, e.surname FROM `key` k INNER JOIN employee e ON e.employee_id=k.employee WHERE k.room ='.$roomId);

        while ($row = $keys->fetch()){
            $html = $html."<dd><a style='text-decoration:none' href='zamestnanec.php?employeeId={$row->employee_id}'>".htmlspecialchars($row->surname)." ".substr(htmlspecialchars($row->ename), 0, 1).".</a></dd>";

        }
        $html = $html."<br><h3><a style='text-decoration:none' href=mistnosti.php>Zpět na Seznam místností </a></h3>";
        echo $html;
    }
        ?>
    </div>
    <header>
        <?php

        $card = $pdo->query('SELECT room_id, no, name, phone FROM room WHERE room_id='.$roomId);
        while ($row = $card->fetch()){
            echo "<title>Karta místnosti č. ".htmlspecialchars($row->no)."</title>";
        }
        unset($card);
        unset($employees);
        unset($keys);
        ?>
    </header>
</body>
</html>