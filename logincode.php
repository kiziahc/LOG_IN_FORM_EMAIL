<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('db.php');

if (isset($_POST['login_btn'])) {
    if (!empty(trim($_POST['email'])) && !empty(trim($_POST['password']))) {
        $email = strtolower(trim(mysqli_real_escape_string($con, $_POST['email'])));
        $password = $_POST['password']; // Don't escape password, it will be hashed

        // Use a prepared statement for security
        $stmt = $con->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "User found in database.<br>"; // Debug message
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                echo "Password matches.<br>"; // Debug message

                if ($row['verify_status'] == 1) {
                    $_SESSION['authenticated'] = TRUE;
                    $_SESSION['auth_user'] = [
                        'username' => $row['name'],
                        'phone' => $row['phone'],
                        'email' => $row['email'],
                    ];
                    $_SESSION['status'] = "You are Logged In Successfully!";
                    header("Location: dashboard.php");
                    exit(0);
                } else {
                    $_SESSION['status'] = "Please verify your Email Address to Login.";
                    header("Location: login.php");
                    exit(0);
                }
            } else {
                echo "Password does not match.<br>"; // Debug message
                $_SESSION['status'] = "Incorrect Password";
                header("Location: login.php");
                exit(0);
            }
        } else {
            echo "No user found with this email.<br>"; // Debug message
            $_SESSION['status'] = "Invalid Email or Password";
            header("Location: login.php");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "All fields are mandatory";
        header("Location: login.php");
        exit(0);
    }
}
?>
