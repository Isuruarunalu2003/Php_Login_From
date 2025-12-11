<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Get user's first name
$first_name = $_SESSION["first_name"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Welcome, <?= htmlspecialchars($first_name) ?>!</h2>
    <p>You are now logged in.</p>

    <a href="otherpage.php"><button>Go to Other Page</button></a>
    <a href="logout.php"><button>Logout</button></a>
</div>

</body>
</html>
