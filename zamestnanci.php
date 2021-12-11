<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Zamestnanci</title>
</head>
<body class="Container">
<h1>Seznam zaměstnanců</h1>
        <?php
        require_once ("includes/db_connect.inc.php");
        $poradi = filter_input(INPUT_GET,"poradi");

        $stmt;

        switch ($poradi) {
            case "jmeno_desc" :
                $stmt = $pdo->query('SELECT employee_id, employee.name AS emp_name, employee.surname AS emp_surname, employee.job AS emp_job, room.name AS room_name, room.phone AS room_phone FROM employee LEFT JOIN room ON room.room_id = employee.room ORDER BY employee.name DESC');
                break;
            case "jmeno_asc" :
                $stmt = $pdo->query('SELECT employee_id, employee.name AS emp_name, employee.surname AS emp_surname, employee.job AS emp_job, room.name AS room_name, room.phone AS room_phone FROM employee LEFT JOIN room ON room.room_id = employee.room ORDER BY employee.name ASC');
                break;
            case "mistnost_desc" :
                $stmt = $pdo->query('SELECT employee_id, employee.name AS emp_name, employee.surname AS emp_surname, employee.job AS emp_job, room.name AS room_name, room.phone AS room_phone FROM employee LEFT JOIN room ON room.room_id = employee.room ORDER BY room.name DESC');
                break;
            case "mistnost_asc" :
                $stmt = $pdo->query('SELECT employee_id, employee.name AS emp_name, employee.surname AS emp_surname, employee.job AS emp_job, room.name AS room_name, room.phone AS room_phone FROM employee LEFT JOIN room ON room.room_id = employee.room ORDER BY room.name ASC');
                break;
            case "telefon_desc" :
                $stmt = $pdo->query('SELECT employee_id, employee.name AS emp_name, employee.surname AS emp_surname, employee.job AS emp_job, room.name AS room_name, room.phone AS room_phone FROM employee LEFT JOIN room ON room.room_id = employee.room ORDER BY room.phone DESC');
                break;
            case "telefon_asc" :
                $stmt = $pdo->query('SELECT employee_id, employee.name AS emp_name, employee.surname AS emp_surname, employee.job AS emp_job, room.name AS room_name, room.phone AS room_phone FROM employee LEFT JOIN room ON room.room_id = employee.room ORDER BY room.phone ASC');
                break;
            case "pozice_desc" :
                $stmt = $pdo->query('SELECT employee_id, employee.name AS emp_name, employee.surname AS emp_surname, employee.job AS emp_job, room.name AS room_name, room.phone AS room_phone FROM employee LEFT JOIN room ON room.room_id = employee.room ORDER BY employee.job DESC');
                break;
            case "pozice_asc" :
                $stmt = $pdo->query('SELECT employee_id, employee.name AS emp_name, employee.surname AS emp_surname, employee.job AS emp_job, room.name AS room_name, room.phone AS room_phone FROM employee LEFT JOIN room ON room.room_id = employee.room ORDER BY employee.job ASC');
                break;
            default:
                $stmt = $pdo->query('SELECT employee_id, employee.name AS emp_name, employee.surname AS emp_surname, employee.job AS emp_job, room.name AS room_name, room.phone AS room_phone FROM employee LEFT JOIN room ON room.room_id = employee.room;');
                break;
        }
        
        if ($stmt->rowCount() == 0) {
            echo "Databáze je prázdná";
        } else {
            echo "<table class = 'table table-striped'>";
            echo "<thead><th>Jméno<a href='zamestnanci.php?poradi=jmeno_desc'<i class='bi bi-arrow-down'></i><a href='zamestnanci.php?poradi=jmeno_asc'<i class='bi bi-arrow-up'></i></th><th>Místnost<a href='zamestnanci.php?poradi=mistnost_desc'<i class='bi bi-arrow-down'></i><a href='zamestnanci.php?poradi=mistnost_asc'<i class='bi bi-arrow-up'></i></th><th>Telefon<a href='zamestnanci.php?poradi=telefon_desc'<i class='bi bi-arrow-down'></i><a href='zamestnanci.php?poradi=telefon_asc'<i class='bi bi-arrow-up'></i></th><th>Pozice<a href='zamestnanci.php?poradi=pozice_desc'<i class='bi bi-arrow-down'></i><a href='zamestnanci.php?poradi=pozice_asc'<i class='bi bi-arrow-up'></i></th></thead>";
            echo "<tbody>";
            foreach ($stmt as $row) {
                echo "<tr>";
                echo "<td><a href='zamestnanec.php?employeeId={$row->employee_id}'>" .htmlspecialchars($row->emp_name). " " .htmlspecialchars($row->emp_surname)."</a></td>";
                echo "<td>" . htmlspecialchars($row->room_name)."</td>";
                echo "<td>". ( $row->room_phone ?: "&mdash;" ) . "</td>";
                echo "<td>". htmlspecialchars($row->emp_job)."</td>";
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