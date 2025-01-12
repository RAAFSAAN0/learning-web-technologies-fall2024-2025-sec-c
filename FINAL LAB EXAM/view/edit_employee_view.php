<?php
session_start();
require_once('../controller/edit_employee_controller.php');

$employee = getEmployeeById($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../asset/edit_employee.js"></script>
</head>
<body>
    <h1>Edit Employee</h1>

    <form id="edit-employee-form" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($employee['id']) ?>" />
        <label for="employer_name">Employer Name:</label>
        <input type="text" id="employer_name" name="employer_name" value="<?= htmlspecialchars($employee['employer_name']) ?>" required />

        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name" value="<?= htmlspecialchars($employee['company_name']) ?>" required />

        <label for="contact_no">Contact No:</label>
        <input type="text" id="contact_no" name="contact_no" value="<?= htmlspecialchars($employee['contact_no']) ?>" required />

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($employee['username']) ?>" required />

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?= htmlspecialchars($employee['password']) ?>" required />

        <button type="submit" id="save-button">Save</button>
    </form>

</body>
</html>
