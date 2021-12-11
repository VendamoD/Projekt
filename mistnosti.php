<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <!-- Bootstrap-->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <title>Mistnosti</title>
    </head>
    <body class = "Container">
        <h1>Seznam místností</h1>
        <?php
        require_once ("includes/db_connect.inc.php");
        $poradi = filter_input(INPUT_GET,"poradi");

        $stmt = $pdo->query('SELECT * FROM room');

        switch ($poradi) {
            case "jmeno_desc" :
                $stmt = $pdo->query('SELECT * FROM room ORDER BY room.name DESC');
                break;
            case "jmeno_asc" :
                $stmt = $pdo->query('SELECT * FROM room ORDER BY room.name ASC');
                break;
            case "cislo_desc" :
                $stmt = $pdo->query('SELECT * FROM room ORDER BY room.no DESC');
                break;
            case "cislo_asc" :
                $stmt = $pdo->query('SELECT * FROM room ORDER BY room.no ASC');
                break;
            case "telefon_desc" :
                $stmt = $pdo->query('SELECT * FROM room ORDER BY room.phone DESC');
                break;
            case "telefon_asc" :
                $stmt = $pdo->query('SELECT * FROM room ORDER BY room.phone ASC');
                break;
            default:
                $stmt = $pdo->query('SELECT * FROM room');
                break;
        }
        
        if ($stmt->rowCount() == 0) {
            echo "Databáze je prázdná";
        } else {
            echo "<table class = 'table table-striped'>";
            echo "<thead><th>Název<a href='mistnosti.php?poradi=jmeno_desc'<i class='bi bi-arrow-down'></i><a href='mistnosti.php?poradi=jmeno_asc'<i class='bi bi-arrow-up'></i></th><th>Číslo<a href='mistnosti.php?poradi=cislo_desc'<i class='bi bi-arrow-down'></i><a href='mistnosti.php?poradi=cislo_asc'<i class='bi bi-arrow-up'></i></th><th>Tel.<a href='mistnosti.php?poradi=telefon_desc'<i class='bi bi-arrow-down'></i><a href='mistnosti.php?poradi=telefon_asc'<i class='bi bi-arrow-up'></i></th></thead>";
            echo "<tbody>";
            while ($row = $stmt->fetch()) { 
                echo "<tr>";
                echo "<td><a href='mistnost.php?roomIxd=$row->room_id'>" . htmlspecialchars($row->name) . "</td></a>";
                echo "<td>" . htmlspecialchars($row->no) . "</td>";
                echo "<td>". ( $row->phone ?: "&mdash;" ) . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
        unset($stmt);
        echo "<p><a href='index.php'>Zpět na prohlížeč databáze.</a></p>";
        ?>
    </body>
</html>