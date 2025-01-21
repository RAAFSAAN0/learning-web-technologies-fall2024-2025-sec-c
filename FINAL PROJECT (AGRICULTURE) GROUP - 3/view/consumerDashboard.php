<?php
session_start();
require_once('../model/database.php');

// Check if the user is logged in as a 'Consumer'
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'Consumer') {
    header('Location: ../view/login.html');
    exit();
}

// Fetch the logged-in user's data
$consumerData = fetchConsumerByEmail($_SESSION['email']);
$first_name = $consumerData['first_name'];
$last_name = $consumerData['last_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consumer Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background: #f8f9fa;
        }

        /* Video Background */
        .video-container {
            position: relative;
            width: 100%;
            height: 100vh;
            
        }

        .video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        /* Welcome Message */
        .welcome-message {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
            font-size: 6rem;
            font-weight:bold;
            font-weight: bold;
            opacity: 0;
            z-index: 1;
            animation: fadeInOut 4s ease-in-out forwards;
        }

        .welcome-name {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            font-weight: normal;
            opacity: 0;
            z-index: 1; /* stacking*/
            animation: fadeIn 5s ease-in-out 3s forwards;
        }

        /* Animations */
        @keyframes fadeInOut {
            0% {
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }

        /* Navigation Bar */
        .nav {
            background: rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 10px 0;
            z-index: 1;
            text-align: center;
        }

        .nav-list {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 0;
        }

        .nav-link {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background 0.3s ease-in-out;
        }

        .nav-link:hover {
            background: rgba(139, 126, 250, 0.5);
        }



        /* Main Section Styling */
.main {
    margin-top: -0px;
    padding: 0px;
    text-align: center;
}

/* Section Container */
.section {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 50px;
    margin-bottom: 0px;
    border-radius: 10px; /* Rounded corners */
    color: white;
}

.mission-section {
    background-color:rgb(212, 212, 212); 
}

.vision-section {
    background-color:rgb(255, 255, 255);
}

.goals-section {
    background-color:rgb(192, 192, 192); 
}

.section-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 3200px;
    color: black;
    width: 100%;
    gap: 20px;
}

.section-text {
    flex: 1;
}

.section-text h2 {
    margin-bottom: 10px;
    font-size: 2rem;
}

.section-text p {
    font-size: 1.2rem;
    line-height: 1.6;
}

.section-image {
    max-width: 40%;
    height: auto;
    border-radius: 10px;
}



        .footer {
            text-align: center;
            background: #1c2025;
            color: #fff;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="video-container">
        <video class="video-background" autoplay muted loop>
            <source src="../asset/video/4k.mp4" type="video/mp4">
        </video>

        <div class="welcome-message" id="welcomeMessage">Welcome to AgriConnect!</div>
        <div class="welcome-name" id="welcomeName">
            <?php echo $first_name . ' ' . $last_name; ?><br>
            Cherishing you a very happy day!
        </div>
    </div>

    <nav class="nav">
        <ul class="nav-list">
            <li><a class="nav-link" href="consumerDashboard.php">Dashboard</a></li>
            <li><a class="nav-link" href="buy_product.php">Buy Products</a></li>
            <li><a class="nav-link" href="cart_details.php">Shopping Cart</a></li>
            <li><a class="nav-link" href="video_list.php">Video Tutorials</a></li>
            <li><a class="nav-link" href="../controller/purchase_history.php">Purchase History</a></li>
            <li><a class="nav-link" href="../controller/consumer_view.php">View Profile</a></li>
            <li><a class="nav-link" href="consumer_settings.php">Settings</a></li>
            <li><a class="nav-link" href="consumer_account.php">Account</a></li>
            <li><a class="nav-link" href="../controller/logout.php">Logout</a></li>
        </ul>
    </nav>

    <main class="main">
    <section class="section mission-section">
        <div class="section-content">
            <img src="../asset/images/mission.jpg" alt="Mission" class="section-image left">
            <div class="section-text">
                <h2>Our Mission</h2>
                <p>Enhance agricultural productivity by connecting farmers with consumers, promoting sustainable practices.</p>
            </div>
        </div>
    </section>

    <section class="section vision-section">
        <div class="section-content">
            <div class="section-text">
                <h2>Our Vision</h2>
                <p>To lead agricultural innovation and empower communities with reliable solutions.</p>
            </div>
            <img src="../asset/images/vision.png" alt="Vision" class="section-image right">
        </div>
    </section>

    <section class="section goals-section">
        <div class="section-content">
            <img src="../asset/images/goals.jpg" alt="Goals" class="section-image left">
            <div class="section-text">
                <h2>Our Goals</h2>
                <p>Foster sustainability, innovation, and community focus in agriculture.</p>
            </div>
        </div>
    </section>
</main>



    <footer class="footer">
        <p>© 2025 Designed by Rafsan Mahmud All Rights Reserved</p>
    </footer>

</body>
</html>
