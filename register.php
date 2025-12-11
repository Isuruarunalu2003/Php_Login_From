<?php
require "config.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first = $_POST['first_name'];
    $middle = $_POST['middle_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (first_name, middle_name, phone, email, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $first, $middle, $phone, $email, $password);

    if ($stmt->execute()) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'isuruarunalu.20@gmail.com';
            $mail->Password   = 'rxww jdbt mndp nkvn';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;
            $mail->setFrom('isuruarunalu.20@gmail.com', 'Website Registration');
            $mail->addAddress('isuruarunalu.20@gmail.com'); // admin email
            $mail->isHTML(true);
            $mail->Subject = "New User Registered";
            $mail->Body    = "
                <h3>New User Registered</h3>
                <p><b>First Name:</b> $first</p>
                <p><b>Middle Name:</b> $middle</p>
                <p><b>Phone:</b> $phone</p>
                <p><b>Email:</b> $email</p>
            ";
            $mail->send();
        } catch (Exception $e) {
        }
        header("Location: login.php?registered=1");
        exit();
    } else {
        $message = "Error: Something went wrong.";
    }
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
        height: 500px;
        padding: 40px;
        background: rgba(0, 0, 0, , 0.2); 
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        z-index: 15; 
    }

    .text-background-h2 {
        font-size: 28px;
        margin-bottom: 20px;
        text-align: center;
        color: #333; 
    }

    .form-container input[type="email"],
    .form-container input[type="password"] {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 10px;
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
    <title>Register - AleX</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="hero-wrapper"> 
        <nav>
        <div class="left">
            <img src="./src/logo.svg" class="logo" alt="Logo">
        </div>
        <a href="login.php" class="register-btn">Login Now</a> 
    </nav>

        <div class="hero">
        <h1>REGISTER YOUR<br>ACCOUNT</h1>
        <p>
            Join a community built for growth, discovery, and connection.
            Experience exclusive content and tools designed for your future.
        </p>
        <a href="./src/contact.html" class="join-btn">CONTACT ME</a>
    </div>
        <div class="form-container">
            <form action="" method="POST">
                <h2 class="text-background-h2">CREATE ACCOUNT</h2> 
                <?php if(!empty($message)) { echo '<p class="msg">'.$message.'</p>'; } ?>

                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="middle_name" placeholder="Middle Name (Optional)">
                <input type="text" name="phone" placeholder="Phone Number" required>
                <input type="email" name="email" placeholder="Email Address" required>

                <input type="password" name="password" id="pass" placeholder="Password" required>
                <span id="strength"></span>
                <button type="submit" class="register-button">Register</button>
                <p class="register-link">Have alredy an account <a href="login.php">Login here !</a></p>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>