<?php
session_start();
require_once('../model/database.php');
include('navbar.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Consumer') {
    echo "Please log in to view your account.";
    exit;
}

$consumer_id = $_SESSION['user_id']; 

$conn = mysqli_connect('127.0.0.1', 'root', '', 'agriculture');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT balance FROM consumer_account WHERE consumer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $consumer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $balance = $row['balance'];
} else {
    $balance = 0; 
}

$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deposit_amount'])) {
    $deposit_amount = floatval($_POST['deposit_amount']);
    if ($deposit_amount > 0) 
    
    
    
    {


        // Check if an account already exists
        $account_check_sql = "SELECT * FROM consumer_account WHERE consumer_id = ?";
        $account_check_stmt = $conn->prepare($account_check_sql);
        $account_check_stmt->bind_param("i", $consumer_id);
        $account_check_stmt->execute();
        $account_exists = $account_check_stmt->get_result()->num_rows > 0;
        $account_check_stmt->close();

        if ($account_exists) 
        
        {
            // Update existing account balance
            $update_sql = "UPDATE consumer_account SET balance = balance + ? WHERE consumer_id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("di", $deposit_amount, $consumer_id);
            $update_stmt->execute();
            $update_stmt->close();
        } else {
            // Create a new account with the deposited amount
            $insert_sql = "INSERT INTO consumer_account (consumer_id, balance) VALUES (?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("id", $consumer_id, $deposit_amount);
            $insert_stmt->execute();
            $insert_stmt->close();
        }

        $balance += $deposit_amount; // Update balance locally
        echo "Amount deposited successfully.";
    } else {
        echo "Invalid deposit amount.";
    }
}

// Lucky Wheel to add money
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['spin_wheel']) && isset($_POST['wheel_winner'])) {
    $winnings = floatval($_POST['wheel_winner']);
    
    if ($winnings > 0) {
        // Update the balance in the database after the wheel spin
        $update_sql = "UPDATE consumer_account SET balance = balance + ? WHERE consumer_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("di", $winnings, $consumer_id);
        $update_stmt->execute();
        $update_stmt->close();
        
        // Update local balance
        $balance += $winnings;
        
        echo "Congratulations! You've won $$winnings!<br>";
        echo "And $$winnings! has been deposited to your account.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Balance</title>
    <style>
        /* Style for the wheel */
        .wheel-container {
            width: 500px;
            height: 500px;
            margin: 20px auto;
            position: relative;
        }
        #canvas {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 5px solid #ddd;
        }
        .center-circle {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -25px;
            margin-left: -25px;
            width: 50px;
            height: 50px;
            background-color: #ff0;
            border-radius: 50%;
            cursor: pointer;
        }
        .triangle {
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 12px solid #ff0;
            margin: 10px auto;
        }
    </style>
</head>
<body>
    <h1>Account Balance</h1>
    <p><strong>Current Balance:</strong> $<?php echo number_format($balance, 2); ?></p>

    <h2>Deposit Amount</h2>
    <form method="POST">
        <label for="deposit_amount">Amount:</label>
        <input type="number" name="deposit_amount" id="deposit_amount" min="0.01" step="0.01" required>
        <button type="submit">Deposit</button>
    </form>

    <h2>Spin the Lucky Wheel</h2>
    <form method="POST">
        <div class="wheel-container">
            <canvas id="canvas" width="500" height="500"></canvas>
            <div class="center-circle" onclick="spin()">
                <div class="triangle"></div>
            </div>
        </div>
        <input type="hidden" name="wheel_winner" id="wheel_winner" value="0">
        <button type="submit" name="spin_wheel">Spin</button>
    </form>

    <script>
        const canvas = document.getElementById("canvas");
        const ctx = canvas.getContext("2d");
        const width = canvas.width;
        const height = canvas.height;

        const centerX = width / 2;
        const centerY = height / 2;
        const radius = width / 2;

        const winnings = [50, 100, 200, 300, 500, 1000]; // Prize amounts
        let currentDeg = 0;
        let step = 360 / winnings.length;
        let itemDegs = {};

        function randomColor() {
            return {
                r: Math.floor(Math.random() * 255),
                g: Math.floor(Math.random() * 255),
                b: Math.floor(Math.random() * 255)
            };
        }

        function toRad(deg) {
            return deg * (Math.PI / 180.0);
        }

        function draw() {
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius, toRad(0), toRad(360));
            ctx.fillStyle = `rgb(33, 33, 33)`;
            ctx.lineTo(centerX, centerY);
            ctx.fill();

            let startDeg = currentDeg;
            for (let i = 0; i < winnings.length; i++, startDeg += step) {
                let endDeg = startDeg + step;

                let color = randomColor();
                let colorStyle = `rgb(${color.r},${color.g},${color.b})`;

                ctx.beginPath();
                ctx.arc(centerX, centerY, radius - 2, toRad(startDeg), toRad(endDeg));
                let colorStyle2 = `rgb(${color.r - 30},${color.g - 30},${color.b - 30})`;
                ctx.fillStyle = colorStyle2;
                ctx.lineTo(centerX, centerY);
                ctx.fill();

                ctx.beginPath();
                ctx.arc(centerX, centerY, radius - 30, toRad(startDeg), toRad(endDeg));
                ctx.fillStyle = colorStyle;
                ctx.lineTo(centerX, centerY);
                ctx.fill();

                // Draw the prize amount text
                ctx.save();
                ctx.translate(centerX, centerY);
                ctx.rotate(toRad((startDeg + endDeg) / 2));
                ctx.textAlign = "center";
                ctx.fillStyle = "#fff";
                ctx.font = 'bold 24px serif';
                ctx.fillText("$" + winnings[i], 130, 10);
                ctx.restore();

                itemDegs["$" + winnings[i]] = { startDeg, endDeg };
            }
        }

        function spin() {
            let winnerIndex = Math.floor(Math.random() * winnings.length);
            let winnerAmount = winnings[winnerIndex];
            document.getElementById("wheel_winner").value = winnerAmount;

            // Start spinning the wheel animation
            currentDeg = 0;
            draw();
            let maxRotation = 360 * 5 + itemDegs["$" + winnerAmount].endDeg + 10;
            animate(maxRotation);
        }

        function animate(maxRotation) {
            let speed = 0;
            let pause = false;

            if (pause) return;

            speed = easeOutSine(getPercent(currentDeg, maxRotation, 0)) * 20;

            if (speed < 0.01) {
                speed = 0;
                pause = true;
            }

            currentDeg += speed;
            draw();
            window.requestAnimationFrame(() => animate(maxRotation));
        }

        function easeOutSine(x) {
            return Math.sin((x * Math.PI) / 2);
        }

        function getPercent(input, min, max) {
            return (((input - min) * 100) / (max - min)) / 100;
        }

        // Initialize the wheel drawing
        draw();
    </script>
</body>
</html>
