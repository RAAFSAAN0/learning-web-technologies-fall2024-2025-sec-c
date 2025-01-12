<?php
session_start();
require_once('../controller/show_employees_controller.php'); 


// if (!isset($_SESSION['employee_id'])) {
//     header('Location: login.php');
//     exit;
// }
// ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../asset/search.js"></script> 
    <script src="../asset/delete.js"></script> 
    <script src="../asset/edit_employee.js"></script> 
    


    <style>
        .search-container {
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Employee List</h1>


    <div class="search-container">
        <input type="text" id="search" placeholder="Search by name..." onkeyup="searchEmployees()" />
    </div>

  
    <table border="2" cellspacing="33" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Employer Name</th>
                <th>Company Name</th>
                <th>Contact No</th>
                <th>Username</th>
                <th>Password</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="employee-table">
            <?php foreach ($employees as $employee): ?>
                <tr id="row-<?= htmlspecialchars($employee['id']) ?>" class="employee-row">
                    <td><?= htmlspecialchars($employee['id']) ?></td>
                    <td><?= htmlspecialchars($employee['employer_name']) ?></td>
                    <td><?= htmlspecialchars($employee['company_name']) ?></td>
                    <td><?= htmlspecialchars($employee['contact_no']) ?></td>
                    <td><?= htmlspecialchars($employee['username']) ?></td>
                    <td><?= htmlspecialchars($employee['password']) ?></td>
                    <td>
                        <button onclick="window.location.href='edit_employee_view.php?id=<?= $employee['id'] ?>'">Edit</button>
                        <button onclick="deleteEmployee(<?= $employee['id'] ?>)">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>
    <form action="add_employee_view.php" method="get">
        <button type="submit">Add Employee</button>
    </form>

     <br>
    <br>
    

    <a href="login.php">LOG OUT</a>
</body>
</html>
