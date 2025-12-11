<?php
require "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $hashed_password = $user['password'];

        
        if (password_verify($password, $hashed_password)) {
            header("Location: logout.php"); 
            exit();
        } else {
            
            $message = "Invalid email or password.";
        }
    } else {
        
        $message = "Invalid email or password.";
    }

    $stmt->close();
}

if (isset($_GET['registered']) && $_GET['registered'] == 1) {
    $message = "Registration successful! Please log in.";
}
?>

<!DOCTYPE html>
<html>
<style>
    body {
        margin: 0; 
    font-family: sans-serif; 
    overflow-x: hidden;
    overflow-y: hidden; 
    }
    .hero-wrapper {
        min-height: 100vh;
        background: url('./src/background.jpg') no-repeat center center/cover; 
        position: relative;
    }
    nav {
        width: 100%;
        padding: 15px 50px;
        background: rgba(0,0,0,0.25);
        display: flex;
        justify-content: space-between;
        align-items: center;
        backdrop-filter: blur(10px);
        position: relative; 
        z-index: 10; 
        margin-top: -15px; 
    }
    nav img.logo {
        width: 80px;
        height: 50px;
        border-radius: 50%;
    }
    nav .about {
        font-size: 18px;
        color: #000;
        text-decoration: none;
        font-weight: 500;
    }
    nav .register-btn {
        padding: 10px 25px;
        border-radius: 20px;
        background: linear-gradient(90deg, #34bfd7ff, #5a00ff);
        color: white;
        text-decoration: none;
        font-weight: 500;
    }
    nav .register-btn:hover {
        transform: scale(1.06);
    }
    .hero {
        position: absolute; 
        top: 0; 
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        padding-left: 80px;
        padding-top: 175px; 
        color: white;
    }
    .hero h1 {
        font-size: 60px;
        font-weight: 700;
        max-width: 600px;
        line-height: 1.2;
    }
    .hero p {
        max-width: 450px;
        margin-top: 20px;
        font-size: 20px;
        letter-spacing: 0.1px;
    }
    .join-btn {
        display: inline-block;
        margin-top: 35px;
        padding: 15px 40px;
        background: linear-gradient(90deg, #00d4ff, #0066ff);
        border-radius: 30px;
        color: white;
        text-decoration: none;
        font-size: 20px;
        font-weight: 500;
        transition: 0.3s;
    }
    .join-btn:hover {
        transform: scale(1.06);
    }

    .form-container {
        position: absolute; 
        top: 55%;
        right: 100px; 
        transform: translateY(-50%);
        width: 400px; 
        padding: 40px;
        background: rgba(0, 0, 0, 0.2); 
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        z-index: 15; 
    }

    .text-background-h2 {
        font-size: 28px;
        margin-bottom: 30px;
        text-align: center;
        color: #333;
    }

    .form-container input[type="email"],
    .form-container input[type="password"] {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    .login-button {
        width: 100%;
        padding: 15px;
        border: none;
        border-radius: 20px;
        background: linear-gradient(90deg, #00d4ff, #0066ff); 
        color: white;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s;
    }

    .login-button:hover {
        transform: scale(1.02);
    }

    .form-container p.msg {
        color: red;
        font-weight: bold;
        margin-bottom: 15px;
        text-align: center;
    }
    .form-container p.register-link {
        margin-top: 20px;
        text-align: center;
        font-size: 14px;
        color: #fff;
    }
    .form-container p.register-link a {
        color: #0066ff;
        text-decoration: none;
        font-weight: 600;
    }

</style>
<head>
    <title>Login - AleX</title>
    <link rel="stylesheet" href="style.css"> </head>

<body>
    <div class="hero-wrapper"> 
        <nav>
            <div class="left">
                <img src="./src/logo.svg" class="logo" alt="Logo">
            </div>
            <a href="register.php" class="register-btn">Register</a> 
        </nav>

        <div class="hero">
            <h1>WELCOME BACK<br>TO ALE X</h1>
            <p>
                Log in to continue your journey of growth, discovery, and connection.
                Access exclusive content and tools designed for your future.
            </p>
            <a href="https://github.com/Isuruarunalu2003" class="join-btn">LEARN MORE</a>
        </div>
        
        <div class="form-container">
            <form action="" method="POST">
                <h2 class="text-background-h2">LOG IN HERE</h2> 
                <?php if(!empty($message)) { echo '<p class="msg">'.$message.'</p>'; } ?>

                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="password" placeholder="Password" required>

                <button type="submit" class="login-button">Log In</button>
                
                <p class="register-link">Don't have an account? <a href="register.php">Register here</a></p>
            </form>
        </div>
    </div>

    </body>
</html>