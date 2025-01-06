<?php
session_start();

require_once('../model/database.php');
include('../view/navbar.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Create connection to the database
$conn = mysqli_connect('127.0.0.1', 'root', '', 'agriculture');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch purchase history of the logged-in user
$stmt = $conn->prepare("SELECT cp.purchase_id, c.crop_name, cp.amount_bought, cp.purchase_date, cp.transaction_type
                        FROM consumer_purchase cp
                        JOIN crop c ON cp.crop_id = c.crop_id
                        WHERE cp.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Start output buffering to include navbar
ob_start();

// Include the navbar from the view folder (it will be captured in the buffer)
include('../view/navbar.php');

// Capture everything else (the content of the page) after the navbar
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History</title>
    <link rel="stylesheet" href="../asset/navbar.css">
</head>
<body>
    <h1>Your Purchase History</h1>

    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='10' style='width: 80%; margin: auto;'>";
        echo "<tr>
                <th>Purchase ID</th>
                <th>Crop Name</th>
                <th>Amount Bought</th>
                <th>Purchase Date</th>
                <th>Transaction Type</th>
              </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['purchase_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['crop_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['amount_bought']) . " kg</td>";
            echo "<td>" . htmlspecialchars($row['purchase_date']) . "</td>";
            echo "<td>" . htmlspecialchars($row['transaction_type']) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No purchase history found.</p>";
    }
    ?>

</body>
</html>

<?php
// End buffering and flush the output to the browser
ob_end_flush();

// Close the connection
$conn->close();
?>
