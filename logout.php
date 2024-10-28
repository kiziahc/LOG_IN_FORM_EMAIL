<?php
session_start();

unset($_SESSION['authenticated']);
unset($_SESSION['auth_user']);
$_SESSION['status'] = "You Logged Out Successfully";
header("Location: login.php");

?>
<style>
    /* Hero section background */
    .bg-light.py-5 {
        background-color: #d7b59b; /* Light brown background */
    }

    h1.display-4 {
        color: #6f4c3e; /* Dark brown */
        font-family: 'Comic Sans MS', sans-serif; /* Optional playful font */
        font-weight: bold;
    }

    p.lead {
        color: #8b5a2b; /* Medium brown for the lead text */
    }

    /* Buttons */
    .btn-pink {
        background-color: #8b4513; /* Saddle brown button */
        border-color: #6f4c3e;
        color: white;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-pink:hover {
        background-color: #6f4c3e; /* Darker brown on hover */
        border-color: #6f4c3e;
    }

    .btn-outline-pink {
        color: #6f4c3e;
        border-color: #6f4c3e;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-outline-pink:hover {
        background-color: #6f4c3e;
        color: white;
    }

    /* Features Section */
    .py-5 {
        background-color: #f5f5dc; /* Beige for features section */
    }

    h5 {
        color: #8b5a2b; /* Medium brown for feature titles */
        font-family: 'Comic Sans MS', sans-serif;
    }

    p {
        color: #6f4c3e; /* Dark brown for feature descriptions */
    }

    .text-primary {
        color: #6f4c3e !important; /* Align text-primary with the theme */
    }

    .text-success {
        color: #6f4c3e !important; /* Align icons with the theme */
    }

    .text-info {
        color: #8b5a2b !important; /* Use medium brown for info icons */
    }
</style>
<?php include('includes/footer.php'); ?>
