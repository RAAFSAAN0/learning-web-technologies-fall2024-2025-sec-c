<?php
require_once('../model/db.php');

$conn = getConnection();

$employees = getAllEmployees($conn);

$conn->close();
?>
