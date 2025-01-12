<?php
require_once('../model/db.php');

$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';


$conn = getConnection();

$query = "SELECT * FROM employees WHERE employer_name LIKE ?";
$stmt = $conn->prepare($query);
$searchQueryParam = "%" . $searchQuery . "%";  
$stmt->bind_param("s", $searchQueryParam);


$stmt->execute();
$result = $stmt->get_result();

while ($employee = $result->fetch_assoc()) {
    echo "<tr id='row-".htmlspecialchars($employee['id'])."' class='employee-row'>";
    echo "<td>".htmlspecialchars($employee['id'])."</td>";
    echo "<td>".htmlspecialchars($employee['employer_name'])."</td>";
    echo "<td>".htmlspecialchars($employee['company_name'])."</td>";
    echo "<td>".htmlspecialchars($employee['contact_no'])."</td>";
    echo "<td>".htmlspecialchars($employee['username'])."</td>";
    echo "<td>".htmlspecialchars($employee['password'])."</td>";
    echo "<td>
            <button onclick=\"window.location.href='edit_employee.php?id=".$employee['id']."'\">Edit</button>
            <button onclick=\"deleteEmployee(".$employee['id'].")\">Delete</button>
          </td>";
    echo "</tr>";
}

$stmt->close();
$conn->close();
?>
