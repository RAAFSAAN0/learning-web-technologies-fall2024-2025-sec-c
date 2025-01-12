
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <script src="../asset/add_employee.js" defer></script>
</head>
<body>
    <h1>Add New Employee</h1>

    <form id="addEmployeeForm">
        <label for="employer_name">Employer Name:</label>
        <input type="text" id="employer_name" name="employer_name" required>

        <br>
        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name" required>
        <br>
        <label for="contact_no">Contact No:</label>
        <input type="text" id="contact_no" name="contact_no" required>
        <br>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
         <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <br><br>

        <button type="submit">Add Employee</button>
    </form>

</body>
</html>
