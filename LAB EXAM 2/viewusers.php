<?php

$users = file('usersinformation.txt');

$data = [];
$user = [];
foreach ($users as $line) {
    $line = trim($line);
  
    if (strpos($line, " = ") !== false) {
        list($key, $value) = explode(" = ", $line);
        
     
        if ($key == 'id') {
            if (!empty($user)) {
             
                $data[] = $user;
            }
           
            $user = ['id' => $value];
        } else {
            $user[$key] = $value;
        }
    }
}

if (!empty($user)) {
    $data[] = $user;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<h2>User Information</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Password</th>
        <th>Name</th>
        <th>User Type</th>
    </tr>
    <?php
 
    foreach ($data as $user) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($user['id']) . "</td>";
        echo "<td>" . htmlspecialchars($user['password']) . "</td>";
        echo "<td>" . htmlspecialchars($user['name']) . "</td>";
        echo "<td>" . htmlspecialchars($user['user']) . "</td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
